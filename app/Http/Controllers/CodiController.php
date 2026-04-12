<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Codi;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CodiController extends Controller
{
    public function index()
    {
        $codis = Codi::with('user')->latest('data_escaneig')->paginate(20);

        if (view()->exists('codis.index')) {
            return view('codis.index', compact('codis'));
        }

        return redirect()->route('dashboard')->with('info', 'La vista pública de codis no està disponible.');
    }

    public function create()
    {
        if (view()->exists('codis.create')) {
            return view('codis.create');
        }

        return redirect()->route('dashboard')->with('info', 'La vista de creació de codis no està disponible.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codi' => 'required|string|max:255',
            'punts' => 'required|integer|min:0',
            'user_id' => 'nullable|exists:users,id',
            'data_escaneig' => 'nullable|date',
        ]);

        $codi = Codi::create([
            'codi' => $validated['codi'],
            'punts' => $validated['punts'],
            'user_id' => $validated['user_id'] ?? null,
            'data_escaneig' => $validated['data_escaneig'] ?? now(),
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'id' => $codi->id]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Codi creat correctament.');
    }

    public function show($id)
    {
        $codi = Codi::with('user')->findOrFail($id);

        if (view()->exists('codis.show')) {
            return view('codis.show', compact('codi'));
        }

        return redirect()->route('dashboard')->with('info', 'La vista de detall de codis no està disponible.');
    }

    public function edit($id)
    {
        $codi = Codi::findOrFail($id);

        if (view()->exists('codis.edit')) {
            return view('codis.edit', compact('codi'));
        }

        return redirect()->route('dashboard')->with('info', 'La vista d\'edició de codis no està disponible.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'codi' => 'required|string|max:255',
            'punts' => 'required|integer|min:0',
            'user_id' => 'nullable|exists:users,id',
            'data_escaneig' => 'nullable|date',
        ]);

        $codi = Codi::findOrFail($id);
        $codi->update($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Codi actualitzat correctament.');
    }

    public function destroy(Request $request, $id)
    {
        $codi = Codi::findOrFail($id);
        $codi->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Codi eliminat correctament.');
    }

    /**
     * Procesa un código escaneado y asigna puntos
     */
    public function processCode(Request $request)
    {
        try {
            $validated = $request->validate([
                // Accepta codis alfanumèrics i evita caràcters especials innecessaris.
                'code' => ['required', 'string', 'min:8', 'max:64', 'regex:/^[A-Za-z0-9]+$/'],
            ]);

            $code = $validated['code'];
            $user = Auth::user();

            return DB::transaction(function () use ($code, $user) {
                $lockedUser = User::query()->whereKey($user->id)->lockForUpdate()->firstOrFail();

                // Verificar si el usuario ha escaneado este código recientemente (últimos 5 minutos)
                $ultimoEscaneo = Codi::query()
                    ->where('codi', $code)
                    ->where('user_id', $lockedUser->id)
                    ->where('data_escaneig', '>=', Carbon::now()->subMinutes(5))
                    ->lockForUpdate()
                    ->first();

                if ($ultimoEscaneo) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Has d\'esperar 5 minuts abans de tornar a escanejar aquest codi'
                    ]);
                }

                // Calcular puntos según el código (puedes modificar esta lógica)
                $puntos = $this->calcularPuntos($code);

                // Guardar el nuevo escaneo
                $codi = new Codi();
                $codi->codi = $code;
                $codi->user_id = $lockedUser->id;
                $codi->punts = $puntos;
                $codi->data_escaneig = Carbon::now();
                $codi->save();

                // Actualizar puntos del usuario
                $lockedUser->punts_actuals += $puntos;
                $lockedUser->punts_totals += $puntos;
                $lockedUser->save();

                // Registrar actividad
                Activity::create([
                    'user_id' => $lockedUser->id,
                    'action' => 'Ha escanejat el codi ' . $code . ' i ha guanyat ' . $puntos . ' punts'
                ]);

                return response()->json([
                    'success' => true,
                    'points' => $puntos,
                    'new_total' => $lockedUser->punts_actuals,
                    'message' => 'Has guanyat ' . $puntos . ' ECODAMS'
                ]);
            });
            
        } catch (\Exception $e) {
            Log::error('Error procesando código', [
                'error' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'S\'ha produït un error intern en processar el codi.'
            ], 500);
        }
    }
    
    /**
     * Calcula los puntos basados en el código de barras
     * Puedes implementar aquí tu propia lógica de puntuación
     */
    private function calcularPuntos($code)
    {
        // Ejemplo: asignar puntos basados en la longitud o algún algoritmo
        // En este caso simple, damos entre 10 y 20 puntos
        return random_int(10, 20);
        
        // Alternativa: usar los últimos dígitos del código como puntos
        // return min(50, max(5, intval(substr($code, -2))));
    }
}