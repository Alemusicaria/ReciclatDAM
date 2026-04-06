<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Artisan::command('routes:check {--locale=ca : Locale to use for localized routes} {--only= : Optional comma-separated route name filter} {--json : Output JSON instead of a table}', function () {
    $router = app('router');
    $routes = $router->getRoutes();
    $locale = (string) $this->option('locale');
    $onlyFilter = array_filter(array_map('trim', explode(',', (string) $this->option('only'))));
    $buildCheckUri = static function (string $uri, string $locale): ?string {
        $uri = trim($uri, '/');

        if ($uri === '') {
            return '/';
        }

        $tokenValue = \App\Models\PasswordResetToken::query()->value('token') ?: Str::random(40);
        $knownNumericParameters = [
            'id',
            'user',
            'event',
            'premi',
            'premiReclamat',
            'producte',
            'punt',
            'rol',
            'codi',
            'tipusEvent',
            'tipusAlerta',
            'alertaPuntDeRecollida',
            'session',
            'cache',
            'migrations',
            'opinion',
        ];

        $uri = preg_replace_callback('/\{([^}]+)\}/', static function (array $matches) use ($locale, $tokenValue, $knownNumericParameters) {
            $parameter = rtrim($matches[1], '?');

            if ($parameter === 'locale') {
                return $locale;
            }

            if ($parameter === 'token') {
                return $tokenValue;
            }

            if (in_array($parameter, $knownNumericParameters, true) || str_ends_with($parameter, 'Id')) {
                return '1';
            }

            return $matches[0];
        }, $uri);

        if (preg_match('/\{[^}]+\}/', $uri)) {
            return null;
        }

        return '/' . $uri;
    };

    $results = [];

    foreach ($routes as $route) {
        $methods = array_diff($route->methods(), ['HEAD']);

        if (!in_array('GET', $methods, true)) {
            continue;
        }

        $name = $route->getName() ?? $route->uri();

        if ($onlyFilter && !in_array($name, $onlyFilter, true)) {
            continue;
        }

        $uri = $buildCheckUri($route->uri(), $locale);
        if ($uri === null) {
            $results[] = [
                'name' => $name,
                'uri' => $route->uri(),
                'status' => 'SKIP',
                'message' => 'Contains required parameters that cannot be inferred safely',
            ];
            continue;
        }

        $request = Request::create($uri, 'GET', [], [], [], [
            'HTTP_HOST' => parse_url(config('app.url'), PHP_URL_HOST) ?: 'localhost',
            'HTTPS' => parse_url(config('app.url'), PHP_URL_SCHEME) === 'https' ? 'on' : 'off',
        ]);

        try {
            $response = app()->handle($request);
            $status = $response->getStatusCode();
            $message = match (true) {
                $status >= 200 && $status < 300 => 'OK',
                $status >= 300 && $status < 400 => 'REDIRECT',
                $status === 401 || $status === 403 => 'AUTH/NO ACCESS',
                $status === 404 => 'NOT FOUND',
                default => 'ERROR',
            };

            $results[] = [
                'name' => $name,
                'uri' => $uri,
                'status' => $status,
                'message' => $message,
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => $name,
                'uri' => $uri,
                'status' => 'EXC',
                'message' => Str::limit($e->getMessage(), 120),
            ];
        }
    }

    $summary = [
        'total' => count($results),
        'ok' => count(array_filter($results, static fn (array $row) => is_int($row['status']) && $row['status'] >= 200 && $row['status'] < 300)),
        'redirect' => count(array_filter($results, static fn (array $row) => is_int($row['status']) && $row['status'] >= 300 && $row['status'] < 400)),
        'auth_or_forbidden' => count(array_filter($results, static fn (array $row) => in_array($row['status'], [401, 403], true))),
        'not_found' => count(array_filter($results, static fn (array $row) => $row['status'] === 404)),
        'skipped' => count(array_filter($results, static fn (array $row) => $row['status'] === 'SKIP')),
        'exceptions' => count(array_filter($results, static fn (array $row) => $row['status'] === 'EXC')),
    ];

    if ($this->option('json')) {
        $this->line(json_encode([
            'summary' => $summary,
            'routes' => $results,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return;
    }

    $this->table(['Route', 'URI', 'Status', 'Result'], array_map(static function (array $row) {
        return [$row['name'], $row['uri'], (string) $row['status'], $row['message']];
    }, $results));

    $this->newLine();
    $this->info('Checked ' . $summary['total'] . ' GET routes.');
})->purpose('Check public GET routes and report if they work');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
