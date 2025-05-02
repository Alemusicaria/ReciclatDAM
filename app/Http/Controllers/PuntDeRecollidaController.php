<?php

namespace App\Http\Controllers;

use App\Models\PuntDeRecollida;
use Illuminate\Http\Request;

class PuntDeRecollidaController extends Controller
{
    public function index()
    {
        $puntsDeRecollida = PuntDeRecollida::all(); // Obtenim tots els punts de recollida
        return view('punts_de_recollida.index', compact('puntsDeRecollida'));
    }
    
    public function create()
    {
        return view('punts_de_recollida.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'ciutat' => 'required',
            'adreça' => 'required',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'fracció' => 'required',
        ]);

        PuntDeRecollida::create($request->all());
        return redirect()->route('punts_de_recollida.index')->with('success', 'Punt de recollida creat correctament.');
    }

    public function show(PuntDeRecollida $puntDeRecollida)
    {
        return view('punts_de_recollida.show', compact('puntDeRecollida'));
    }

    public function edit(PuntDeRecollida $puntDeRecollida)
    {
        return view('punts_de_recollida.edit', compact('puntDeRecollida'));
    }

    public function update(Request $request, PuntDeRecollida $puntDeRecollida)
    {
        $request->validate([
            'nom' => 'required',
            'ciutat' => 'required',
            'adreça' => 'required',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'fracció' => 'required',
        ]);

        $puntDeRecollida->update($request->all());
        return redirect()->route('punts_de_recollida.index')->with('success', 'Punt de recollida actualitzat correctament.');
    }

    public function destroy(PuntDeRecollida $puntDeRecollida)
    {
        $puntDeRecollida->delete();
        return redirect()->route('punts_de_recollida.index')->with('success', 'Punt de recollida eliminat correctament.');
    }
}