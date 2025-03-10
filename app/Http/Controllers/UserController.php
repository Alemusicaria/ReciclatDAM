<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
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
        ]);
        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
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