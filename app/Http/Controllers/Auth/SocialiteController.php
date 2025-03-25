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

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $findUser = User::where('email', $user->getEmail())->first();

            if ($findUser) {
                Auth::login($findUser);
                Log::info('User logged in: ' . $findUser->email);
                return redirect()->intended('dashboard');
            } else {
                $avatar = $user->getAvatar();
                if (!str_starts_with($avatar, 'https://')) {
                    $avatar = 'images/default-profile.png';
                }

                // Crear l'usuari amb una contrasenya temporal
                $newUser = User::create([
                    'nom' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make('temporary_password'), // Contrasenya temporal
                    'rol_id' => 2,
                    'foto_perfil' => $avatar // Guardar la foto de perfil
                ]);

                // Guardar l'usuari a la sessió per utilitzar-lo després
                session(['social_user' => $newUser]);
                session(['social_login' => true]);
                Log::info('New user created and stored in session: ' . $newUser->email);

                // Loguejar l'usuari
                Auth::login($newUser);

                // Redirigir al dashboard
                return redirect()->intended('dashboard');
            }

        } catch (Exception $e) {
            Log::error('Error logging in with ' . $provider . ': ' . $e->getMessage());
            return redirect('login')->withErrors(['msg' => 'Error logging in with ' . $provider]);
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