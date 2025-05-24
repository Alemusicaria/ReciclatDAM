<?php

namespace App\Http\Controllers;

use App\Models\PremiReclamat;
use App\Models\Premi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

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

    public function edit($id)
    {
        $premiReclamat = PremiReclamat::findOrFail($id);
        return view('admin.edit.premi-reclamat', compact('premiReclamat'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'estat' => 'required|in:pendent,procesant,entregat,cancelat',
                'codi_seguiment' => 'nullable|string',
                'comentaris' => 'nullable|string',
            ]);

            $premiReclamat = PremiReclamat::findOrFail($id);

            // Generar código de seguimiento si está vacío y estado es procesant
            if ($request->estat == 'procesant' && empty($request->codi_seguiment)) {
                $codiSeguiment = $this->generarCodiSeguimentUnic();
                $premiReclamat->codi_seguiment = $codiSeguiment;
            } else {
                $premiReclamat->codi_seguiment = $request->codi_seguiment;
            }

            $premiReclamat->estat = $request->estat;
            $premiReclamat->comentaris = $request->comentaris;
            $premiReclamat->save();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha actualitzat l\'estat del premi reclamat #' . $id . ' a ' . $request->estat
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Estat del premi reclamat actualitzat correctament'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Estat del premi reclamat actualitzat correctament.');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function destroy(PremiReclamat $premiReclamat)
    {
        try {
            // Si el premio no ha sido entregado, devolver puntos al usuario
            if ($premiReclamat->estat != 'entregat' && $premiReclamat->user) {
                $user = $premiReclamat->user;
                $user->punts_actuals += $premiReclamat->punts_gastats;
                $user->punts_gastats -= $premiReclamat->punts_gastats;
                $user->save();
            }

            // Guardar información antes de eliminar
            $premiId = $premiReclamat->id;
            $premiNom = $premiReclamat->premi ? $premiReclamat->premi->nom : 'Premi #' . $premiId;
            $userName = $premiReclamat->user ? $premiReclamat->user->nom : 'usuari desconegut';

            $premiReclamat->delete();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha eliminat el premi reclamat #' . $premiId . ' (' . $premiNom . ') per a ' . $userName
                ]);
            }

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Premi reclamat eliminat correctament'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Premi reclamat eliminat correctament.');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar premi reclamat: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function userClaims($userId)
    {
        $user = User::findOrFail($userId);
        $premisReclamats = $user->premisReclamats()->with('premi')->get();

        return response()->json($premisReclamats);
    }
    public function approve($id)
    {
        try {
            $premiReclamat = PremiReclamat::findOrFail($id);
            $premiReclamat->estat = 'procesant';

            // Generar código de seguimiento único
            $codiSeguiment = $this->generarCodiSeguimentUnic();
            $premiReclamat->codi_seguiment = $codiSeguiment;

            $premiReclamat->save();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha aprovat la sol·licitud de premi #' . $premiReclamat->id . ' per a ' .
                        ($premiReclamat->user ? $premiReclamat->user->nom : 'usuari desconegut')
                ]);
            }

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sol·licitud aprovada correctament'
                ]);
            }

            return redirect()->back()->with('success', 'Sol·licitud aprovada correctament');
        } catch (\Exception $e) {
            \Log::error('Error al aprovar premi reclamat: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Generar un código de seguimiento único
     */
    private function generarCodiSeguimentUnic()
    {
        $prefix = 'TRK';
        $codiExists = true;
        $codi = '';

        // Generar códigos hasta encontrar uno único
        while ($codiExists) {
            // Generar un código alfanumérico aleatorio
            $randomPart = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
            $codi = $prefix . '-' . $randomPart;

            // Verificar que no exista ya
            $codiExists = PremiReclamat::where('codi_seguiment', $codi)->exists();
        }

        return $codi;
    }

    public function reject($id)
    {
        $premiReclamat = PremiReclamat::findOrFail($id);

        // Si se rechaza, devolver puntos al usuario
        $user = $premiReclamat->user;
        if ($user) {
            $user->punts_actuals += $premiReclamat->punts_gastats;
            $user->punts_gastats -= $premiReclamat->punts_gastats;
            $user->save();
        }

        $premiReclamat->estat = 'cancelat';
        $premiReclamat->comentaris = ($premiReclamat->comentaris ? $premiReclamat->comentaris . "\n" : '') .
            'Sol·licitud rebutjada el ' . now()->format('d/m/Y H:i') . ' per ' . auth()->user()->nom;
        $premiReclamat->save();

        // Registrar actividad
        if (auth()->check()) {
            Activity::create([
                'user_id' => auth()->id(),
                'action' => 'Ha rebutjat la sol·licitud de premi #' . $premiReclamat->id . ' per a ' . $premiReclamat->user->nom
            ]);
        }

        return response()->json(['success' => true]);
    }
}