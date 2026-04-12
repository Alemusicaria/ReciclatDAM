<?php

namespace App\Http\Controllers;

use App\Models\AlertaPuntDeRecollida;
use App\Models\PuntDeRecollida;
use App\Models\TipusAlerta;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Auth\Guard;
use App\Support\UploadedFileSecurity;

class AlertaPuntDeRecollidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['index', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $alertes = AlertaPuntDeRecollida::with('puntDeRecollida', 'tipus')->get();
        if (!view()->exists('alertes_punts_de_recollida.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista de llistat d\'alertes no està disponible.');
        }
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
                'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $alerta = new AlertaPuntDeRecollida();
            $alerta->punt_de_recollida_id = $validatedData['punt_de_recollida_id'];
            $alerta->tipus_alerta_id = $validatedData['tipus_alerta_id'];
            $alerta->descripció = $validatedData['descripció'];

            // Asignar el usuario actual si está autenticado
            /** @var Guard $auth */
            $auth = auth();
            if ($auth->check()) {
                $alerta->user_id = $auth->id();
            }

            // Procesar y guardar la imagen si existe
            if ($request->hasFile('imatge')) {
                $alerta->imatge = UploadedFileSecurity::storeImage(
                    $request->file('imatge'),
                    'images/alertes'
                );
            }

            $alerta->save();

            // Registrar actividad
            /** @var Guard $auth */
            $auth = auth();
            if ($auth->check()) {
                Activity::create([
                    'user_id' => $auth->id(),
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

            return redirect()->route('scanner')->with('success', __('messages.system.alert_created_success'));
        } catch (\Exception $e) {
            Log::error('Error al crear alerta: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No s\'ha pogut crear l\'alerta.'
                ], 422);
            }

            return back()->withErrors(['error' => __('messages.system.alert_create_error')]);
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

        if (!view()->exists('alertes_punts_de_recollida.edit')) {
            return redirect()->route('dashboard')->with('info', 'La vista d\'edició d\'alertes no està disponible.');
        }

        return view('alertes_punts_de_recollida.edit', compact('alertaPuntDeRecollida', 'puntsDeRecollida', 'tipusAlertes'));
    }

    public function update(Request $request, AlertaPuntDeRecollida $alertaPuntDeRecollida)
    {
        try {
            $validatedData = $request->validate([
                'punt_de_recollida_id' => 'required|exists:punts_de_recollida,id',
                'tipus_alerta_id' => 'required|exists:tipus_alertes,id',
                'descripció' => 'required|string',
                'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'eliminar_imatge' => 'nullable',
            ]);

            $alertaPuntDeRecollida->punt_de_recollida_id = $validatedData['punt_de_recollida_id'];
            $alertaPuntDeRecollida->tipus_alerta_id = $validatedData['tipus_alerta_id'];
            $alertaPuntDeRecollida->descripció = $validatedData['descripció'];

            // Gestionar la imagen
            if ($request->hasFile('imatge')) {
                UploadedFileSecurity::deleteStoredFile($alertaPuntDeRecollida->imatge);
                $alertaPuntDeRecollida->imatge = UploadedFileSecurity::storeImage(
                    $request->file('imatge'),
                    'images/alertes'
                );
            }
            // Si se marca eliminar imagen pero no hay nueva imagen
            elseif ($request->has('eliminar_imatge') && $request->eliminar_imatge == 1) {
                // Eliminar la imagen actual si existe
                UploadedFileSecurity::deleteStoredFile($alertaPuntDeRecollida->imatge);
                $alertaPuntDeRecollida->imatge = null;
            }

            $alertaPuntDeRecollida->save();

            // Registrar actividad
            /** @var Guard $auth */
            $auth = auth();
            if ($auth->check()) {
                Activity::create([
                    'user_id' => $auth->id(),
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

            return redirect()->route('admin.dashboard')->with('success', __('messages.system.alert_updated_success'));
        } catch (\Exception $e) {
            Log::error('Error al actualitzar alerta: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No s\'ha pogut actualitzar l\'alerta.'
                ], 422);
            }

            return back()->withErrors(['error' => __('messages.system.alert_update_error')]);
        }
    }

    public function destroy(AlertaPuntDeRecollida $alertaPuntDeRecollida)
    {
        try {
            // Eliminar la imagen si existe
            UploadedFileSecurity::deleteStoredFile($alertaPuntDeRecollida->imatge);

            $alertaPuntDeRecollida->delete();

            // Registrar actividad
            /** @var Guard $auth */
            $auth = auth();
            if ($auth->check()) {
                Activity::create([
                    'user_id' => $auth->id(),
                    'action' => 'Ha eliminat l\'alerta ID: ' . $alertaPuntDeRecollida->id
                ]);
            }

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Alerta eliminada correctament'
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', __('messages.system.alert_deleted_success'));
        } catch (\Exception $e) {
            Log::error('Error al eliminar alerta: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No s\'ha pogut eliminar l\'alerta.'
                ], 500);
            }

            return back()->withErrors(['error' => __('messages.system.alert_delete_error')]);
        }
    }
}