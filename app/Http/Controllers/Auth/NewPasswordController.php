<?php

namespace App\Http\Controllers\Auth;

use App\Mail\SecurityPasswordChangedMail;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class NewPasswordController extends Controller
{
    /**
     * Mostrar la vista de restablecimiento de contraseña.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
        ]);

        return view('auth.reset-password', [
            'token' => e($request->token),
            'email' => e($request->email)
        ]);
    }

    /**
     * Manejar la solicitud de restablecimiento de contraseña.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->mixedCase()->numbers()],
        ]);

        // Aquí procesamos la solicitud de restablecimiento
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();

                if (
                    !app()->environment('testing')
                    && is_string($user->email)
                    && filter_var($user->email, FILTER_VALIDATE_EMAIL)
                ) {
                    Mail::to($user->email)->queue(new SecurityPasswordChangedMail($user));
                }

                event(new PasswordReset($user));
            }
        );

        // Redirigir según el resultado
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}