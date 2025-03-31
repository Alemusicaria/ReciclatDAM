<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('rol')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $rols = Rol::all();
        return view('users.create', compact('rols'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
            'data_naixement' => 'nullable|date',
            'telefon' => 'nullable|string|max:15',
            'ubicacio' => 'nullable|string',
            'punts_totals' => 'nullable|integer',
            'punts_actuals' => 'nullable|integer',
            'punts_gastats' => 'nullable|integer',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'nullable|integer|exists:rols,id',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = new User($request->all());
        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('profile_photos', 'public');
            $user->foto_perfil = $path;
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $rols = Rol::all();
        return view('users.edit', compact('user', 'rols'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom' => 'nullable|string|max:255',
            'cognoms' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'data_naixement' => 'nullable|date',
            'telefon' => 'nullable|string|max:15',
            'ubicacio' => 'nullable|string|max:255',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validació per a la foto de perfil
        ]);

        // Actualitzar camps de l'usuari
        $user->update($request->only(['nom', 'cognoms', 'email', 'data_naixement', 'telefon', 'ubicacio']));

        // Si s'ha pujat una nova foto de perfil
        if ($request->hasFile('foto_perfil')) {
            // Esborra la foto de perfil antiga si existeix
            if ($user->foto_perfil) {
                Storage::disk('public')->delete($user->foto_perfil);
            }

            // Desa la nova foto de perfil
            $path = $request->file('foto_perfil')->store('profile_photos', 'public');
            $user->foto_perfil = $path;
            $user->save();
        }

        return redirect()->route('users.show', $user->id)->with('success', 'Perfil actualitzat correctament.');
    }


    public function destroy(User $user)
    {
        if ($user->foto_perfil) {
            Storage::disk('public')->delete($user->foto_perfil);
        }
        $user->delete();
        return redirect()->route('users.index');
    }
}