<?php

namespace App\Http\Controllers;

use App\Models\AlertaPuntDeRecollida;
use App\Models\PuntDeRecollida;
use App\Models\TipusAlerta;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlertaPuntDeRecollidaController extends Controller
{
    public function index()
    {
        $alertes = AlertaPuntDeRecollida::with('puntDeRecollida', 'tipus')->get();
        return view('alertes_punts_de_recollida.index', compact('alertes'));
    }

    public function create()
    {
        $puntsDeRecollida = PuntDeRecollida::all();
        $tipusAlertes = TipusAlerta::all();
        return view('alertes_punts_de_recollida.create', compact('puntsDeRecollida', 'tipusAlertes'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'punt_de_recollida_id' => 'required|exists:punts_de_recollida,id',
                'tipus_alerta_id' => 'required|exists:tipus_alertes,id',
                'descripció' => 'required|string',
                'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $alerta = new AlertaPuntDeRecollida();
            $alerta->punt_de_recollida_id = $validatedData['punt_de_recollida_id'];
            $alerta->tipus_alerta_id = $validatedData['tipus_alerta_id'];
            $alerta->descripció = $validatedData['descripció'];

            // Asignar el usuario actual si está autenticado
            if (auth()->check()) {
                $alerta->user_id = auth()->id();
            }

            // Procesar y guardar la imagen si existe
            if ($request->hasFile('imatge')) {
                $file = $request->file('imatge');
                $filename = 'alerta_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/alertes'), $filename);
                $alerta->imatge = 'images/alertes/' . $filename;
            }

            $alerta->save();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha creat una nova alerta per al punt de recollida ID: ' . $alerta->punt_de_recollida_id
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Alerta creada correctament',
                    'alerta' => $alerta
                ]);
            }

            return redirect()->route('scanner')->with('success', 'Problema reportat correctament. Gràcies per la teva col·laboració!');
        } catch (\Exception $e) {
            Log::error('Error al crear alerta: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => 'Error al crear l\'alerta: ' . $e->getMessage()]);
        }
    }

    public function show(AlertaPuntDeRecollida $alertaPuntDeRecollida)
    {
        return view('alertes_punts_de_recollida.show', compact('alertaPuntDeRecollida'));
    }

    public function edit(AlertaPuntDeRecollida $alertaPuntDeRecollida)
    {
        $puntsDeRecollida = PuntDeRecollida::all();
        $tipusAlertes = TipusAlerta::all();
        return view('alertes_punts_de_recollida.edit', compact('alertaPuntDeRecollida', 'puntsDeRecollida', 'tipusAlertes'));
    }

    public function update(Request $request, AlertaPuntDeRecollida $alertaPuntDeRecollida)
    {
        try {
            $validatedData = $request->validate([
                'punt_de_recollida_id' => 'required|exists:punts_de_recollida,id',
                'tipus_alerta_id' => 'required|exists:tipus_alertes,id',
                'descripció' => 'required|string',
                'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'eliminar_imatge' => 'nullable',
            ]);

            $alertaPuntDeRecollida->punt_de_recollida_id = $validatedData['punt_de_recollida_id'];
            $alertaPuntDeRecollida->tipus_alerta_id = $validatedData['tipus_alerta_id'];
            $alertaPuntDeRecollida->descripció = $validatedData['descripció'];

            // Gestionar la imagen
            if ($request->hasFile('imatge')) {
                // Si hay una imagen previa, eliminarla
                if ($alertaPuntDeRecollida->imatge && file_exists(public_path($alertaPuntDeRecollida->imatge))) {
                    unlink(public_path($alertaPuntDeRecollida->imatge));
                }

                // Guardar la nueva imagen
                $file = $request->file('imatge');
                $filename = 'alerta_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/alertes'), $filename);
                $alertaPuntDeRecollida->imatge = 'images/alertes/' . $filename;
            }
            // Si se marca eliminar imagen pero no hay nueva imagen
            elseif ($request->has('eliminar_imatge') && $request->eliminar_imatge == 1) {
                // Eliminar la imagen actual si existe
                if ($alertaPuntDeRecollida->imatge && file_exists(public_path($alertaPuntDeRecollida->imatge))) {
                    unlink(public_path($alertaPuntDeRecollida->imatge));
                }
                $alertaPuntDeRecollida->imatge = null;
            }

            $alertaPuntDeRecollida->save();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha actualitzat l\'alerta ID: ' . $alertaPuntDeRecollida->id
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Alerta actualitzada correctament',
                    'alerta' => $alertaPuntDeRecollida
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Alerta actualitzada correctament.');
        } catch (\Exception $e) {
            Log::error('Error al actualitzar alerta: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => 'Error al actualitzar l\'alerta: ' . $e->getMessage()]);
        }
    }

    public function destroy(AlertaPuntDeRecollida $alertaPuntDeRecollida)
    {
        try {
            // Eliminar la imagen si existe
            if ($alertaPuntDeRecollida->imatge && file_exists(public_path($alertaPuntDeRecollida->imatge))) {
                unlink(public_path($alertaPuntDeRecollida->imatge));
            }

            $alertaPuntDeRecollida->delete();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha eliminat l\'alerta ID: ' . $alertaPuntDeRecollida->id
                ]);
            }

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Alerta eliminada correctament'
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Alerta eliminada correctament.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar alerta: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al eliminar l\'alerta: ' . $e->getMessage()]);
        }
    }
}