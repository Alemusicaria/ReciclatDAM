<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PasswordResetToken;
use App\Models\Premi;
use App\Models\PremiReclamat;
use App\Models\Producte;
use App\Models\PuntDeRecollida;
use App\Models\Rol;
use App\Models\TipusAlerta;
use App\Models\TipusEvent;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogicCheckController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user instanceof User || !$user->isAdmin()) {
            abort(403, 'No tens permisos per executar comprovacions de lògica.');
        }

        return view('admin.logic-checker');
    }

    public function run(Request $request)
    {
        $user = Auth::user();

        if (!$user instanceof User || !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tens permisos per executar comprovacions de lògica.',
            ], 403);
        }

        config([
            'mail.default' => 'array',
            'queue.default' => 'sync',
            'scout.driver' => 'null',
        ]);

        $locale = (string) ($request->input('locale') ?: app()->getLocale() ?: 'ca');
        $includeLocalized = (bool) $request->boolean('include_localized', false);
        $currentUser = $request->user();

        $session = app('session')->driver();
        $session->start();
        $csrfToken = $session->token();

        $results = [];

        foreach (app('router')->getRoutes() as $route) {
            $actionName = $route->getActionName();

            if ($actionName === 'Closure' || !str_contains($actionName, '@')) {
                continue;
            }

            if (!$includeLocalized && str_starts_with((string) $route->getName(), 'localized.')) {
                continue;
            }

            if (str_starts_with($route->uri(), 'admin/logic-checker')) {
                continue;
            }

            $method = $this->pickMethod($route->methods());
            if ($method === null) {
                continue;
            }

            $uri = $this->buildUri($route->uri(), $route->parameterNames(), $locale);
            if ($uri === null) {
                $results[] = [
                    'route' => $route->getName() ?: $route->uri(),
                    'controller' => $actionName,
                    'method' => $method,
                    'uri' => $route->uri(),
                    'status' => 'SKIP',
                    'result' => 'Paràmetres sense valor de prova segur.',
                ];
                continue;
            }

            $isMutating = in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'], true);
            $routeMiddleware = $route->gatherMiddleware();
            $hasAuthMiddleware = $this->hasAuthMiddleware($routeMiddleware);
            $hasCsrfMiddleware = $this->hasCsrfMiddleware($routeMiddleware);
            $payload = $this->payloadForRoute($route->uri(), $currentUser);

            if ($isMutating) {
                $payload['_token'] = $csrfToken;
            }

            $internalRequest = Request::create($uri, $method, $payload, [], [], [
                'HTTP_HOST' => parse_url(config('app.url'), PHP_URL_HOST) ?: 'localhost',
                'HTTPS' => parse_url(config('app.url'), PHP_URL_SCHEME) === 'https' ? 'on' : 'off',
                'HTTP_ACCEPT' => 'application/json',
                'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
                'HTTP_X_CSRF_TOKEN' => $csrfToken,
            ]);

            $internalRequest->setUserResolver(static fn () => $currentUser);
            $internalRequest->setLaravelSession($session);

            if ($isMutating) {
                DB::beginTransaction();
            }

            try {
                $response = app()->handle($internalRequest);
                $status = $response->getStatusCode();
                $error = $status >= 400 ? $this->extractError($response->getContent()) : null;
                $result = $this->statusLabel($status, $hasAuthMiddleware, $hasCsrfMiddleware, $isMutating);

                if ($this->isExpectedValidationError($status, $error)) {
                    $result = 'EXPECTED (VALIDATION)';
                } elseif ($this->isExpectedNotFoundError($status, $error)) {
                    $result = 'EXPECTED (NOT FOUND)';
                }

                $results[] = [
                    'route' => $route->getName() ?: $route->uri(),
                    'controller' => $actionName,
                    'method' => $method,
                    'uri' => $uri,
                    'status' => $status,
                    'result' => $result,
                    'error' => $error,
                ];
            } catch (\Throwable $e) {
                // Log detailed error for debugging, but don't expose to client
                \Log::error('LogicCheckController exception', [
                    'route' => $route->getName() ?: $route->uri(),
                    'method' => $method,
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);

                $results[] = [
                    'route' => $route->getName() ?: $route->uri(),
                    'controller' => $actionName,
                    'method' => $method,
                    'uri' => $uri,
                    'status' => 'EXC',
                    'result' => 'EXCEPTION',
                    'error' => 'An error occurred during route processing',
                ];
            } finally {
                if ($isMutating && DB::transactionLevel() > 0) {
                    DB::rollBack();
                }
            }
        }

        // Some checked routes (login/register/logout) may mutate auth state; restore caller session user.
        if ($currentUser) {
            Auth::guard('web')->login($currentUser);
        }

        $summary = [
            'total' => count($results),
            'ok' => count(array_filter($results, static fn (array $row) => is_int($row['status']) && $row['status'] >= 200 && $row['status'] < 300)),
            'redirect' => count(array_filter($results, static fn (array $row) => is_int($row['status']) && $row['status'] >= 300 && $row['status'] < 400)),
            'client_error' => count(array_filter($results, static fn (array $row) => is_int($row['status']) && $row['status'] >= 400 && $row['status'] < 500 && !str_starts_with((string) ($row['result'] ?? ''), 'PROTECTED') && !str_starts_with((string) ($row['result'] ?? ''), 'EXPECTED'))),
            'server_error' => count(array_filter($results, static fn (array $row) => is_int($row['status']) && $row['status'] >= 500)),
            'protected_auth' => count(array_filter($results, static fn (array $row) => ($row['result'] ?? '') === 'PROTECTED (AUTH)')),
            'protected_csrf' => count(array_filter($results, static fn (array $row) => ($row['result'] ?? '') === 'PROTECTED (CSRF)')),
            'expected_validation' => count(array_filter($results, static fn (array $row) => ($row['result'] ?? '') === 'EXPECTED (VALIDATION)')),
            'expected_not_found' => count(array_filter($results, static fn (array $row) => ($row['result'] ?? '') === 'EXPECTED (NOT FOUND)')),
            'exceptions' => count(array_filter($results, static fn (array $row) => $row['status'] === 'EXC')),
            'skipped' => count(array_filter($results, static fn (array $row) => $row['status'] === 'SKIP')),
        ];

        return response()->json([
            'success' => true,
            'summary' => $summary,
            'results' => $results,
        ]);
    }

    private function pickMethod(array $methods): ?string
    {
        foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $preferred) {
            if (in_array($preferred, $methods, true)) {
                return $preferred;
            }
        }

        return null;
    }

    private function buildUri(string $uri, array $parameterNames, string $locale): ?string
    {
        if ($parameterNames === []) {
            return '/' . ltrim($uri, '/');
        }

        $built = $uri;

        foreach ($parameterNames as $parameterName) {
            $value = $this->parameterValue($parameterName, $uri, $locale);
            if ($value === null) {
                return null;
            }

            $built = str_replace('{'.$parameterName.'}', urlencode((string) $value), $built);
            $built = str_replace('{'.$parameterName.'?}', urlencode((string) $value), $built);
        }

        if (preg_match('/\{[^}]+\}/', $built)) {
            return null;
        }

        return '/' . ltrim($built, '/');
    }

    private function parameterValue(string $name, string $uri, string $locale): string|int|null
    {
        return match ($name) {
            'locale' => $locale,
            'provider' => 'google',
            'token' => PasswordResetToken::query()->value('token') ?: Str::random(40),
            'type' => $this->typeValueByUri($uri),
            'user' => User::query()->value('id') ?: 1,
            'event' => Event::query()->value('id') ?: 1,
            'premi' => Premi::query()->value('id') ?: 1,
            'premiReclamat', 'premi_reclamat' => PremiReclamat::query()->value('id') ?: 1,
            'producte' => Producte::query()->value('id') ?: 1,
            'punt', 'punt_de_recollida' => PuntDeRecollida::query()->value('id') ?: 1,
            'rol' => Rol::query()->value('id') ?: 1,
            'tipusEvent' => TipusEvent::query()->value('id') ?: 1,
            'tipusAlerta' => TipusAlerta::query()->value('id') ?: 1,
            'id' => $this->idByUri($uri),
            default => str_ends_with($name, 'id') || str_ends_with($name, '_id') ? 1 : 1,
        };
    }

    private function typeValueByUri(string $uri): string
    {
        return match (true) {
            str_contains($uri, 'modal-content') => 'users',
            str_contains($uri, 'create-form') => 'user',
            str_contains($uri, 'edit-form') => 'user',
            str_contains($uri, 'detail') => 'user',
            str_contains($uri, 'update') => 'user',
            str_contains($uri, 'destroy') => 'user',
            default => 'user',
        };
    }

    private function idByUri(string $uri): int
    {
        return match (true) {
            str_contains($uri, 'events') => Event::query()->value('id') ?: 1,
            str_contains($uri, 'premis-reclamats') => PremiReclamat::query()->value('id') ?: 1,
            str_contains($uri, 'premis') => Premi::query()->value('id') ?: 1,
            str_contains($uri, 'productes') => Producte::query()->value('id') ?: 1,
            str_contains($uri, 'punts') => PuntDeRecollida::query()->value('id') ?: 1,
            str_contains($uri, 'rols') => Rol::query()->value('id') ?: 1,
            default => User::query()->value('id') ?: 1,
        };
    }

    private function payloadForRoute(string $uri, ?User $user): array
    {
        if (str_contains($uri, 'login')) {
            return [
                'email' => $user?->email ?: 'aina.mila@reciclat.test',
                'password' => env('DEMO_USER_PASSWORD', 'password'),
            ];
        }

        if (str_contains($uri, 'register')) {
            return [
                'nom' => 'Diag',
                'cognoms' => 'Runner',
                'email' => 'diag.'.uniqid().'@reciclat.test',
                'password' => 'password',
                'password_confirmation' => 'password',
            ];
        }

        if (str_contains($uri, 'premis-reclamats') && str_contains($uri, 'update')) {
            return [
                'estat' => 'procesant',
                'codi_seguiment' => null,
                'comentaris' => 'Diagnòstic automàtic',
            ];
        }

        return [];
    }

    private function statusLabel(int $status, bool $hasAuthMiddleware, bool $hasCsrfMiddleware, bool $isMutating): string
    {
        if (($status === 401 || $status === 403) && $hasAuthMiddleware) {
            return 'PROTECTED (AUTH)';
        }

        if ($status === 419 && $isMutating && $hasCsrfMiddleware) {
            return 'PROTECTED (CSRF)';
        }

        return match (true) {
            $status >= 200 && $status < 300 => 'OK',
            $status >= 300 && $status < 400 => 'REDIRECT',
            $status >= 400 && $status < 500 => 'CLIENT ERROR',
            $status >= 500 => 'SERVER ERROR',
            default => 'UNKNOWN',
        };
    }

    private function extractError(?string $content): string
    {
        if ($content === null || trim($content) === '') {
            return 'Sense missatge d\'error.';
        }

        $decoded = json_decode($content, true);
        if (is_array($decoded)) {
            if (isset($decoded['message']) && is_string($decoded['message'])) {
                return Str::limit($decoded['message'], 300);
            }

            if (isset($decoded['errors']) && is_array($decoded['errors'])) {
                return Str::limit(json_encode($decoded['errors'], JSON_UNESCAPED_UNICODE), 300);
            }
        }

        return Str::limit(trim(strip_tags($content)), 300);
    }

    private function hasAuthMiddleware(array $middlewares): bool
    {
        foreach ($middlewares as $middleware) {
            $middleware = (string) $middleware;

            if (str_starts_with($middleware, 'auth') || str_contains($middleware, 'Authenticate')) {
                return true;
            }
        }

        return false;
    }

    private function hasCsrfMiddleware(array $middlewares): bool
    {
        foreach ($middlewares as $middleware) {
            $middleware = (string) $middleware;

            if ($middleware === 'web' || $middleware === ValidateCsrfToken::class || str_contains($middleware, 'VerifyCsrfToken') || str_contains($middleware, 'ValidateCsrfToken')) {
                return true;
            }
        }

        return false;
    }

    private function isExpectedValidationError(int $status, ?string $error): bool
    {
        if ($status !== 422) {
            return false;
        }

        $message = mb_strtolower((string) $error);

        return str_contains($message, 'obligatori')
            || str_contains($message, 'required')
            || str_contains($message, 'validation')
            || str_contains($message, 'contrasenya');
    }

    private function isExpectedNotFoundError(int $status, ?string $error): bool
    {
        if ($status !== 404) {
            return false;
        }

        $message = mb_strtolower((string) $error);

        return str_contains($message, 'no query results for model');
    }
}
