<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
            'data_naieixement' => 'nullable|date',
            'telefon' => 'nullable|string|max:15',
            'ubicacio' => 'nullable|string',
            'punts_totals' => 'required|integer',
            'punts_actuals' => 'required|integer',
            'punts_gastats' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|integer|exists:rols,id',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'cognoms' => $request->cognoms,
            'data_naieixement' => $request->data_naieixement,
            'telefon' => $request->telefon,
            'ubicacio' => $request->ubicacio,
            'punts_totals' => $request->punts_totals,
            'punts_actuals' => $request->punts_actuals,
            'punts_gastats' => $request->punts_gastats,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
        ]);
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
            'nom' => 'required',
            'cognoms' => 'required',
            'data_naieixement' => 'nullable|date',
            'telefon' => 'nullable',
            'ubicacio' => 'nullable',
            'punts_totals' => 'required|integer',
            'punts_actuals' => 'required|integer',
            'punts_gastats' => 'required|integer',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required',
            'rol_id' => 'required|integer|exists:rols,id',
        ]);

        $user->update($request->all());
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}