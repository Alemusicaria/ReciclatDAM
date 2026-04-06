<?php

namespace App\Http\Controllers;

use App\Models\PuntDeRecollida;
use Illuminate\Http\Request;
use App\Models\Activity;

class PuntDeRecollidaController extends Controller
{
    public function index()
    {
        $puntsDeRecollida = PuntDeRecollida::all(); // Obtenim tots els punts de recollida
        if (!view()->exists('punts_de_recollida.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista de punts de recollida no està disponible.');
        }
        return view('punts_de_recollida.index', compact('puntsDeRecollida'));
    }

    public function create()
    {
        if (!view()->exists('punts_de_recollida.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació de punts de recollida no està disponible.');
        }
        return view('punts_de_recollida.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Recibida solicitud para crear punto de recogida');

            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'fraccio' => 'required|string',
                'ciutat' => 'required|string|max:255',
                'adreca' => 'required|string|max:255',
                'latitud' => 'required|numeric',
                'longitud' => 'required|numeric',
                'disponible' => 'nullable|boolean',
            ]);

            // Crear punto de recogida
            $punt = new PuntDeRecollida();
            $punt->nom = $validatedData['nom'];
            $punt->fraccio = $validatedData['fraccio'];
            $punt->ciutat = $validatedData['ciutat'];
            $punt->adreca = $validatedData['adreca']; // Nota: es 'adreca' sin acento
            $punt->latitud = $validatedData['latitud'];
            $punt->longitud = $validatedData['longitud'];
            $punt->disponible = isset($validatedData['disponible']) ? true : false;
            $punt->save();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha creat un nou punt de recollida: ' . $punt->nom
                ]);
            }

            // Para peticiones AJAX (lo que usa tu formulario)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Punt de recollida creat correctament',
                    'punt' => $punt
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Codi creat correctament');

        } catch (\Exception $e) {
            \Log::error('Error al crear punt de recollida: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No s\'ha pogut crear el punt de recollida.'
                ], 422);
            }

            return back()->withErrors(['error' => 'No s\'ha pogut crear el punt de recollida.']);
        }
    }

    public function show(PuntDeRecollida $puntDeRecollida)
    {
        if (!view()->exists('punts_de_recollida.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall de punts de recollida no està disponible.');
        }
        return view('punts_de_recollida.show', compact('puntDeRecollida'));
    }

    public function edit(PuntDeRecollida $puntDeRecollida)
    {
        if (!view()->exists('punts_de_recollida.edit')) {
            return redirect()->route('dashboard')->with('info', 'La vista d\'edició de punts de recollida no està disponible.');
        }
        return view('punts_de_recollida.edit', compact('puntDeRecollida'));
    }

    public function update(Request $request, PuntDeRecollida $punt)
    {
        try {
            // IMPORTANTE: Los nombres de los campos deben coincidir con el modelo
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'fraccio' => 'required|string',      // Sin acento, como en el modelo
                'ciutat' => 'required|string|max:255',
                'adreca' => 'required|string|max:255', // Sin acento, como en el modelo
                'latitud' => 'required|numeric',
                'longitud' => 'required|numeric',
                'disponible' => 'nullable|boolean',
            ]);

            // Actualizar datos
            $punt->nom = $validatedData['nom'];
            $punt->fraccio = $validatedData['fraccio'];
            $punt->ciutat = $validatedData['ciutat'];
            $punt->adreca = $validatedData['adreca'];
            $punt->latitud = $validatedData['latitud'];
            $punt->longitud = $validatedData['longitud'];
            $punt->disponible = isset($validatedData['disponible']) ? true : false;
            $punt->save();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha actualitzat el punt de recollida: ' . $punt->nom
                ]);
            }

            // Para peticiones AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Punt de recollida actualitzat correctament',
                    'punt' => $punt
                ]);
            }

            // Para peticiones normales
            return redirect()->route('admin.dashboard')->with('success', 'Punt de recollida actualitzat correctament.');
        } catch (\Exception $e) {
            \Log::error('Error al actualitzar punt de recollida: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No s\'ha pogut actualitzar el punt de recollida.'
                ], 422);
            }

            return back()->withErrors(['error' => 'No s\'ha pogut actualitzar el punt de recollida.']);
        }
    }

    public function destroy(PuntDeRecollida $puntDeRecollida)
    {
        $puntDeRecollida->delete();
        return redirect()->route('punts_de_recollida.index')->with('success', 'Punt de recollida eliminat correctament.');
    }
}