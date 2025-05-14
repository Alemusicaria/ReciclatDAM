<?php

namespace App\Http\Controllers;

use App\Models\PremiReclamat;
use App\Models\Premi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PremiReclamatController extends Controller
{
    public function index()
    {
        $premisReclamats = PremiReclamat::with(['user', 'premi'])->latest()->paginate(10);
        return view('premis_reclamats.index', compact('premisReclamats'));
    }

    public function create()
    {
        $premis = Premi::all();
        $users = User::all();
        return view('premis_reclamats.create', compact('premis', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'premi_id' => 'required|exists:premis,id',
            'punts_gastats' => 'required|integer|min:0',
            'estat' => 'required|in:pendent,procesant,entregat,cancelat',
            'codi_seguiment' => 'nullable|string',
            'comentaris' => 'nullable|string',
        ]);

        // Verificar si el usuario tiene suficientes puntos
        $user = User::findOrFail($request->user_id);
        $premi = Premi::findOrFail($request->premi_id);
        
        if ($user->punts_actuals < $request->punts_gastats) {
            return back()->with('error', 'L\'usuari no té suficients punts per reclamar aquest premi.');
        }

        // Descontar puntos al usuario
        $user->punts_actuals -= $request->punts_gastats;
        $user->punts_gastats += $request->punts_gastats;
        $user->save();

        // Crear el registro
        $premiReclamat = PremiReclamat::create($request->all());

        return redirect()->route('premis_reclamats.index')
            ->with('success', 'Premi reclamat amb èxit.');
    }

    public function show(PremiReclamat $premiReclamat)
    {
        return view('premis_reclamats.show', compact('premiReclamat'));
    }

    public function edit(PremiReclamat $premiReclamat)
    {
        $premis = Premi::all();
        $users = User::all();
        return view('premis_reclamats.edit', compact('premiReclamat', 'premis', 'users'));
    }

    public function update(Request $request, PremiReclamat $premiReclamat)
    {
        $request->validate([
            'estat' => 'required|in:pendent,procesant,entregat,cancelat',
            'codi_seguiment' => 'nullable|string',
            'comentaris' => 'nullable|string',
        ]);

        $premiReclamat->update($request->only(['estat', 'codi_seguiment', 'comentaris']));

        return redirect()->route('premis_reclamats.index')
            ->with('success', 'Informació del premi reclamat actualitzada.');
    }

    public function destroy(PremiReclamat $premiReclamat)
    {
        // Si el premio no ha sido entregado, devolver puntos al usuario
        if ($premiReclamat->estat != 'entregat') {
            $user = $premiReclamat->user;
            $user->punts_actuals += $premiReclamat->punts_gastats;
            $user->punts_gastats -= $premiReclamat->punts_gastats;
            $user->save();
        }

        $premiReclamat->delete();

        return redirect()->route('premis_reclamats.index')
            ->with('success', 'Premi reclamat eliminat correctament.');
    }
    
    public function userClaims($userId)
    {
        $user = User::findOrFail($userId);
        $premisReclamats = $user->premisReclamats()->with('premi')->get();
        
        return response()->json($premisReclamats);
    }
}