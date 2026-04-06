<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client as GuzzleClient;
use Laravel\Socialite\Two\AbstractProvider;
use Exception;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function showSetPasswordForm()
    {
        if (!session()->has('social_user')) {
            return redirect('login')->withErrors(['msg' => 'No hi ha cap sessió social pendent per establir contrasenya.']);
        }

        return view('auth.set-password');
    }

    public function redirectToProvider($provider)
    {
        if (!$this->isProviderSupported($provider)) {
            return redirect('login')->withErrors(['msg' => 'Proveedor de autenticacion no soportado.']);
        }

        if (!$this->hasProviderConfig($provider)) {
            Log::error('Social login missing provider configuration', ['provider' => $provider]);
            return redirect('login')->withErrors(['msg' => 'Falta configurar el inicio de sesion con ' . $provider . '.']);
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
            return redirect('login')->withErrors(['msg' => 'Proveedor de autenticacion no soportado.']);
        }

        if (!$this->hasProviderConfig($provider)) {
            Log::error('Social login missing provider configuration on callback', ['provider' => $provider]);
            return redirect('login')->withErrors(['msg' => 'Falta configurar el inicio de sesion con ' . $provider . '.']);
        }

        try {
            $socialUser = $this->socialiteDriver($provider)->user();
            $email = $socialUser->getEmail();

            if (empty($email)) {
                Log::warning('Social provider did not return email', ['provider' => $provider]);
                return redirect('login')->withErrors(['msg' => 'No hem pogut obtenir el teu email de ' . $provider . '. Revisa permisos del compte i torna-ho a provar.']);
            }

            $findUser = User::where('email', $email)->first();
    
            // Registrar información detallada para depuración
            Log::info('Social login attempt', [
                'provider' => $provider,
            ]);
    
            if ($findUser) {
                // El usuario ya existe, solo inicia sesión
                Auth::login($findUser, true); // Añadir "true" para "remember me"
                Log::info('Existing social user logged in', ['provider' => $provider]);
                return redirect()->intended('/');
            } else {
                // Crear nuevo usuario
                $avatar = $socialUser->getAvatar();
                if (!str_starts_with($avatar, 'https://')) {
                    $avatar = 'images/default-profile.png';
                }
    
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
                    return redirect('login')->withErrors(['msg' => 'Error creating user account']);
                }
    
                // Forzar recuperación del usuario de la base de datos antes de login
                $newUser = User::where('id', $newUser->id)->first();

                // Login con "remember me" activado
                Auth::login($newUser, true);

                Log::info('New social user created and logged in', ['provider' => $provider]);
    
                // Redirigir a home con flush de sesión
                return redirect('/')->with('success', 'Benvingut/da a Reciclat DAM!');
            }
    
        } catch (Exception $e) {
            Log::error('Social login error', [
                'provider' => $provider,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('login')->withErrors(['msg' => 'Error al iniciar sesión con ' . $provider . '. Por favor, inténtalo de nuevo.']);
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

        // Windows local setups can fail OAuth token exchange due to missing CA bundle.
        if (app()->environment('local') && $driver instanceof AbstractProvider) {
            $driver->setHttpClient(new GuzzleClient(['verify' => false]));
        }

        return $driver;
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = session('social_user');
        if (!$user) {
            Log::error('No user found in session.');
            return redirect('login')->withErrors(['msg' => 'No user found in session.']);
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