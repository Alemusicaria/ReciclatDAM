<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            $findUser = User::where('email', $socialUser->getEmail())->first();
    
            // Registrar información detallada para depuración
            Log::info('Social login attempt', [
                'provider' => $provider,
                'email' => $socialUser->getEmail(),
                'user_exists' => $findUser ? 'yes' : 'no'
            ]);
    
            if ($findUser) {
                // El usuario ya existe, solo inicia sesión
                Auth::login($findUser, true); // Añadir "true" para "remember me"
                Log::info('User logged in: ' . $findUser->email);
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
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(Str::random(16)), // Contraseña aleatoria segura
                    'rol_id' => 2,
                    'foto_perfil' => $avatar,
                    'punts_totals' => 0,
                    'punts_actuals' => 0,
                    'punts_gastats' => 0
                ]);
    
                // Verificar explícitamente que el usuario se creó
                if (!$newUser->exists) {
                    Log::error('Failed to create user', ['email' => $socialUser->getEmail()]);
                    return redirect('login')->withErrors(['msg' => 'Error creating user account']);
                }
    
                // Forzar recuperación del usuario de la base de datos antes de login
                $newUser = User::where('id', $newUser->id)->first();

                // Login con "remember me" activado
                Auth::login($newUser, true);
                
                Log::info('New user created and logged in: ' . $newUser->email);
    
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
        Log::info('User logged in after setting password: ' . $user->email);

        // Eliminar l'usuari de la sessió
        session()->forget('social_user');
        session()->forget('social_login');

        return redirect()->intended('dashboard');
    }
}