<?php

namespace App\Http\Controllers;

use App\Models\TipusAlerta;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TipusAlertaController extends Controller
{
    public function index()
    {
        $tipusAlertes = TipusAlerta::all();
        return view('tipus_alertes.index', compact('tipusAlertes'));
    }

    public function create()
    {
        return view('tipus_alertes.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
            ]);

            $tipusAlerta = TipusAlerta::create($validatedData);

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha creat un nou tipus d\'alerta: ' . $tipusAlerta->nom
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipus d\'alerta creat correctament',
                    'tipusAlerta' => $tipusAlerta
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Tipus d\'alerta creat correctament');
        } catch (\Exception $e) {
            Log::error('Error al crear tipus d\'alerta: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->withErrors(['error' => 'Error al crear el tipus d\'alerta: ' . $e->getMessage()]);
        }
    }

    public function show(TipusAlerta $tipusAlerta)
    {
        return view('tipus_alertes.show', compact('tipusAlerta'));
    }

    public function edit(TipusAlerta $tipusAlerta)
    {
        return view('tipus_alertes.edit', compact('tipusAlerta'));
    }

    public function update(Request $request, TipusAlerta $tipusAlerta)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
            ]);

            $tipusAlerta->update($validatedData);

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha actualitzat el tipus d\'alerta: ' . $tipusAlerta->nom
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipus d\'alerta actualitzat correctament',
                    'tipusAlerta' => $tipusAlerta
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Tipus d\'alerta actualitzat correctament');
        } catch (\Exception $e) {
            Log::error('Error al actualitzar tipus d\'alerta: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->withErrors(['error' => 'Error al actualitzar el tipus d\'alerta: ' . $e->getMessage()]);
        }
    }

    public function destroy(TipusAlerta $tipusAlerta)
    {
        try {
            $tipusAlertaNom = $tipusAlerta->nom;
            
            // Verificar si hay alertas con este tipo antes de eliminar
            if ($tipusAlerta->alertes()->count() > 0) {
                throw new \Exception('No es pot eliminar aquest tipus d\'alerta perquè hi ha alertes que l\'utilitzen');
            }
            
            $tipusAlerta->delete();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha eliminat el tipus d\'alerta: ' . $tipusAlertaNom
                ]);
            }

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipus d\'alerta eliminat correctament'
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Tipus d\'alerta eliminat correctament');
        } catch (\Exception $e) {
            Log::error('Error al eliminar tipus d\'alerta: ' . $e->getMessage());
            
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Error al eliminar el tipus d\'alerta: ' . $e->getMessage()]);
        }
    }
}