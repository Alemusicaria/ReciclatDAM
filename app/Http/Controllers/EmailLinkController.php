<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailLinkController extends Controller
{
    public function redirect(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        $recipientId = (int) $request->query('recipient');
        $target = base64_decode((string) $request->query('target', ''), true);

        if (!is_string($target) || $target === '' || !$this->isSafeTarget($target)) {
            abort(403);
        }

        $signedContinueUrl = \App\Support\EmailActionLink::forTarget(
            new User(['id' => $recipientId]),
            $target,
            60
        );

        if (!$request->user()) {
            session()->put('url.intended', $signedContinueUrl);
            return redirect()->route('login')->with('info', 'Inicia sessio per continuar.');
        }

        if ($request->boolean('switch')) {
            return $this->switchAccount($request, $signedContinueUrl);
        }

        $authUser = $request->user();
        if ((int) $authUser->id !== $recipientId) {
            $recipientUser = User::query()->find($recipientId);
            $switchUrl = \App\Support\EmailActionLink::forTarget(
                new User(['id' => $recipientId]),
                $target,
                60
            ) . '&switch=1';

            return view('auth.email-link-account-mismatch', [
                'targetUrl' => $target,
                'recipientUser' => $recipientUser,
                'currentUser' => $authUser,
                'switchUrl' => $switchUrl,
            ]);
        }

        return redirect()->to($target);
    }

    private function switchAccount(Request $request, string $signedContinueUrl): RedirectResponse
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        session()->put('url.intended', $signedContinueUrl);

        return redirect()->route('login')->with('info', 'Has tancat sessio. Inicia sessio amb el compte correcte.');
    }

    private function isSafeTarget(string $target): bool
    {
        $appUrl = rtrim((string) config('app.url'), '/');

        return str_starts_with($target, '/')
            || ($appUrl !== '' && str_starts_with($target, $appUrl));
    }
}
