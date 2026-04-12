<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client as GuzzleClient;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class SocialiteController extends Controller
{
    public function showSetPasswordForm()
    {
        if (!session()->has('social_user')) {
            return redirect('login')->withErrors(['msg' => __('messages.system.social_session_missing')]);
        }

        return view('auth.set-password');
    }

    public function redirectToProvider($provider)
    {
        if (!$this->isProviderSupported($provider)) {
            return redirect('login')->withErrors(['msg' => __('messages.system.auth_provider_unsupported')]);
        }

        if (!$this->hasProviderConfig($provider)) {
            Log::error('Social login missing provider configuration', ['provider' => $provider]);
            return redirect('login')->withErrors(['msg' => __('messages.system.auth_provider_config_missing', ['provider' => $provider])]);
        }

        $response = $this->socialiteDriver($provider)->redirect();

        Log::info('Social redirect generated', [
            'provider' => $provider,
        ]);

        return $response;
    }

    public function handleProviderCallback($provider)
    {
        if (!$this->isProviderSupported($provider)) {
            return redirect('login')->withErrors(['msg' => __('messages.system.auth_provider_unsupported')]);
        }

        if (!$this->hasProviderConfig($provider)) {
            Log::error('Social login missing provider configuration on callback', ['provider' => $provider]);
            return redirect('login')->withErrors(['msg' => __('messages.system.auth_provider_config_missing', ['provider' => $provider])]);
        }

        try {
            $socialUser = $this->socialiteDriver($provider)->user();
            $email = $socialUser->getEmail();
            $resolvedAvatar = $this->resolveAvatar($socialUser->getAvatar());

            if (empty($email)) {
                Log::warning('Social provider did not return email', ['provider' => $provider]);
                return redirect('login')->withErrors(['msg' => __('messages.system.social_email_missing', ['provider' => $provider])]);
            }

            $findUser = User::where('email', $email)->first();
    
            // Registrar información detallada para depuración
            Log::info('Social login attempt', [
                'provider' => $provider,
            ]);
    
            if ($findUser) {
                // Keep avatar populated if account had no valid image previously.
                $currentAvatar = trim((string) ($findUser->foto_perfil ?? ''));
                if ($currentAvatar === '' || $currentAvatar === 'null') {
                    $findUser->foto_perfil = $resolvedAvatar;
                    $findUser->save();
                }

                // El usuario ya existe, solo inicia sesión
                Auth::login($findUser, true); // Añadir "true" para "remember me"
                Log::info('Existing social user logged in', ['provider' => $provider]);
                return redirect()->intended('/');
            } else {
                // Crear nuevo usuario
                $avatar = $resolvedAvatar;
    
                // Dividir el nombre completo
                $fullName = $socialUser->getName();
                $nameParts = explode(' ', $fullName);
                $firstName = $nameParts[0];
                $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';
    
                // Crear el usuario con todos los campos necesarios
                $newUser = User::create([
                    'nom' => $firstName,
                    'cognoms' => $lastName,
                    'email' => $email,
                    'password' => Hash::make(Str::random(16)), // Contraseña aleatoria segura
                    'rol_id' => 2,
                    'foto_perfil' => $avatar,
                    'punts_totals' => 0,
                    'punts_actuals' => 0,
                    'punts_gastats' => 0
                ]);
    
                // Verificar explícitamente que el usuario se creó
                if (!$newUser->exists) {
                    Log::error('Failed to create user', ['email' => $email]);
                    return redirect('login')->withErrors(['msg' => __('messages.system.social_create_account_error')]);
                }
    
                // Forzar recuperación del usuario de la base de datos antes de login
                $newUser = User::where('id', $newUser->id)->first();

                // Login con "remember me" activado
                Auth::login($newUser, true);

                if (!app()->environment('testing') && !empty($newUser->email)) {
                    Mail::to($newUser->email)->queue(new WelcomeMail($newUser));
                }

                Log::info('New social user created and logged in', ['provider' => $provider]);
    
                // Redirigir a home con flush de sesión
                return redirect('/')->with('success', 'Benvingut/da a Reciclat DAM!');
            }
    
        } catch (Exception $e) {
            Log::error('Social login error', [
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);
            return redirect('login')->withErrors(['msg' => __('messages.system.social_login_error', ['provider' => $provider])]);
        }
    }

    private function isProviderSupported(string $provider): bool
    {
        return in_array($provider, ['google'], true);
    }

    private function hasProviderConfig(string $provider): bool
    {
        return filled(Config::get("services.{$provider}.client_id"))
            && filled(Config::get("services.{$provider}.client_secret"))
            && filled(Config::get("services.{$provider}.redirect"));
    }

    private function socialiteDriver(string $provider)
    {
        $driver = Socialite::driver($provider);

        // Local dev only: avoid state/certificate issues on Windows local setups.
        if (app()->environment(['local', 'development', 'testing'])) {
            if (is_object($driver) && method_exists($driver, 'stateless')) {
                $driver = call_user_func([$driver, 'stateless']);
            }

            if (is_object($driver) && method_exists($driver, 'setHttpClient')) {
                call_user_func([$driver, 'setHttpClient'], new GuzzleClient([
                    'verify' => false,
                    'timeout' => 15,
                ]));
            }
        }

        return $driver;
    }

    private function resolveAvatar(?string $avatar): string
    {
        $avatar = trim((string) $avatar);

        if ($avatar !== '' && str_starts_with($avatar, 'http')) {
            return $avatar;
        }

        return 'images/default-profile.png';
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
        ]);

        $user = session('social_user');
        if (!$user) {
            Log::error('No user found in session.');
            return redirect('login')->withErrors(['msg' => __('messages.system.social_session_user_missing')]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);
        Log::info('User logged in after setting password');

        // Eliminar l'usuari de la sessió
        session()->forget('social_user');
        session()->forget('social_login');

        return redirect()->intended('dashboard');
    }
}