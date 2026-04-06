<?php

namespace App\Http\Controllers;

use App\Models\PremiReclamat;
use App\Models\Premi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class PremiReclamatController extends Controller
{
    public function index()
    {
        $premisReclamats = PremiReclamat::with(['user', 'premi'])->latest()->paginate(10);
        if (!view()->exists('premis_reclamats.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista de premis reclamats no està disponible.');
        }
        return view('premis_reclamats.index', compact('premisReclamats'));
    }

    public function create()
    {
        $premis = Premi::all();
        $users = User::all();
        if (!view()->exists('premis_reclamats.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació de premis reclamats no està disponible.');
        }
        return view('premis_reclamats.create', compact('premis', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'premi_id' => 'required|exists:premis,id',
            'punts_gastats' => 'required|integer|min:0',
            'estat' => 'required|in:pendent,procesant,entregat,cancelat',
            'codi_seguiment' => 'nullable|string',
            'comentaris' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {
            // Verificar si el usuario tiene suficientes puntos
            $user = User::query()->whereKey($validated['user_id'])->lockForUpdate()->firstOrFail();
            $premi = Premi::findOrFail($validated['premi_id']);

            if ($user->punts_actuals < $validated['punts_gastats']) {
                return back()->with('error', 'L\'usuari no té suficients punts per reclamar aquest premi.');
            }

            // Descontar puntos al usuario
            $user->punts_actuals -= $validated['punts_gastats'];
            $user->punts_gastats += $validated['punts_gastats'];
            $user->save();

            // Crear el registro
            PremiReclamat::create($validated);

            return redirect()->route('premis_reclamats.index')
                ->with('success', 'Premi reclamat amb èxit.');
        });
    }

    public function show(PremiReclamat $premiReclamat)
    {
        if (!view()->exists('premis_reclamats.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall de premis reclamats no està disponible.');
        }
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
            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
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
                    'message' => 'S\'ha produït un error en actualitzar el premi reclamat.'
                ], 422);
            }

            return back()->withErrors(['error' => 'S\'ha produït un error en actualitzar el premi reclamat.']);
        }
    }

    public function destroy(PremiReclamat $premiReclamat)
    {
        try {
            DB::transaction(function () use ($premiReclamat) {
                $lockedPremiReclamat = PremiReclamat::query()
                    ->with(['user', 'premi'])
                    ->whereKey($premiReclamat->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Si el premio no ha sido entregado, devolver puntos al usuario
                if ($lockedPremiReclamat->estat != 'entregat' && $lockedPremiReclamat->user) {
                    $user = User::query()->whereKey($lockedPremiReclamat->user_id)->lockForUpdate()->firstOrFail();
                    $user->punts_actuals += $lockedPremiReclamat->punts_gastats;
                    $user->punts_gastats -= $lockedPremiReclamat->punts_gastats;
                    $user->save();
                }

                // Guardar información antes de eliminar
                $premiId = $lockedPremiReclamat->id;
                $premiNom = $lockedPremiReclamat->premi ? $lockedPremiReclamat->premi->nom : 'Premi #' . $premiId;
                $userName = $lockedPremiReclamat->user ? $lockedPremiReclamat->user->nom : 'usuari desconegut';

                $lockedPremiReclamat->delete();

                // Registrar actividad
                if (Auth::check()) {
                    Activity::create([
                        'user_id' => Auth::id(),
                        'action' => 'Ha eliminat el premi reclamat #' . $premiId . ' (' . $premiNom . ') per a ' . $userName
                    ]);
                }
            });

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Premi reclamat eliminat correctament'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Premi reclamat eliminat correctament.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar premi reclamat: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'S\'ha produït un error en eliminar el premi reclamat.'
                ], 500);
            }

            return back()->withErrors(['error' => 'S\'ha produït un error en eliminar el premi reclamat.']);
        }
    }

    public function userClaims($userId)
    {
        $authUser = Auth::user();
        $userId = (int) $userId;

        // Check authorization: must be admin or the user themselves
        $isAdmin = $authUser->rol && $authUser->rol->nom === 'Administrador';
        $isOwner = (int) $authUser->id === $userId;

        if (!$isAdmin && !$isOwner) {
            abort(403, 'No tens permisos per consultar aquestes reclamacions.');
        }

        $user = User::findOrFail($userId);
        $premisReclamats = $user->premisReclamats()->with('premi')->get();

        return response()->json($premisReclamats);
    }
    public function approve($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $premiReclamat = PremiReclamat::query()->with('user')->whereKey($id)->lockForUpdate()->firstOrFail();
                $premiReclamat->estat = 'procesant';

                // Generar código de seguimiento único
                $premiReclamat->codi_seguiment = $this->generarCodiSeguimentUnic();

                $premiReclamat->save();

                // Registrar actividad
                if (Auth::check()) {
                    Activity::create([
                        'user_id' => Auth::id(),
                        'action' => 'Ha aprovat la sol·licitud de premi #' . $premiReclamat->id . ' per a ' .
                            ($premiReclamat->user ? $premiReclamat->user->nom : 'usuari desconegut')
                    ]);
                }
            });

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sol·licitud aprovada correctament'
                ]);
            }

            return redirect()->back()->with('success', 'Sol·licitud aprovada correctament');
        } catch (\Exception $e) {
            Log::error('Error al aprovar premi reclamat: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'S\'ha produït un error en aprovar el premi reclamat.'
                ], 500);
            }

            return back()->withErrors(['error' => 'S\'ha produït un error en aprovar el premi reclamat.']);
        }
    }

    public function approveAllPending()
    {
        try {
            $pendingClaims = PremiReclamat::where('estat', 'pendent')->get();

            if ($pendingClaims->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No hi ha sol·licituds pendents.'
                ]);
            }

            DB::transaction(function () use ($pendingClaims) {
                PremiReclamat::query()
                    ->whereKey($pendingClaims->pluck('id')->all())
                    ->lockForUpdate()
                    ->get()
                    ->each(function (PremiReclamat $premiReclamat) {
                        $premiReclamat->estat = 'procesant';
                        $premiReclamat->codi_seguiment = $this->generarCodiSeguimentUnic();
                        $premiReclamat->save();

                        if (Auth::check()) {
                            Activity::create([
                                'user_id' => Auth::id(),
                                'action' => 'Ha aprovat la sol·licitud de premi #' . $premiReclamat->id . ' per a ' .
                                    ($premiReclamat->user ? $premiReclamat->user->nom : 'usuari desconegut')
                            ]);
                        }
                    });
            });

            return response()->json([
                'success' => true,
                'message' => 'Totes les sol·licituds pendents s\'han aprovat correctament.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al aprovar totes les sol·licituds pendents: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'S\'ha produït un error en aprovar les sol·licituds pendents.'
            ], 500);
        }
    }

    public function deliver($id)
    {
        try {
            $response = DB::transaction(function () use ($id) {
                $premiReclamat = PremiReclamat::query()->with('user')->whereKey($id)->lockForUpdate()->firstOrFail();

                if ($premiReclamat->estat !== 'procesant') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Només es pot marcar com entregat quan està en procés.'
                    ], 422);
                }

                $premiReclamat->estat = 'entregat';
                $premiReclamat->save();

                if (Auth::check()) {
                    Activity::create([
                        'user_id' => Auth::id(),
                        'action' => 'Ha marcat com entregat el premi reclamat #' . $premiReclamat->id . ' per a ' .
                            ($premiReclamat->user ? $premiReclamat->user->nom : 'usuari desconegut')
                    ]);
                }

                return null;
            });

            if ($response instanceof \Illuminate\Http\JsonResponse) {
                return $response;
            }

            return response()->json([
                'success' => true,
                'message' => 'Premi marcat com entregat correctament'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al marcar premi com entregat: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'S\'ha produït un error en marcar el premi com entregat.'
            ], 500);
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
        DB::transaction(function () use ($id) {
            $premiReclamat = PremiReclamat::query()->with('user')->whereKey($id)->lockForUpdate()->firstOrFail();

            // Si se rechaza, devolver puntos al usuario
            if ($premiReclamat->user) {
                $user = User::query()->whereKey($premiReclamat->user_id)->lockForUpdate()->firstOrFail();
                $user->punts_actuals += $premiReclamat->punts_gastats;
                $user->punts_gastats -= $premiReclamat->punts_gastats;
                $user->save();
            }

            $premiReclamat->estat = 'cancelat';
            $premiReclamat->comentaris = ($premiReclamat->comentaris ? $premiReclamat->comentaris . "\n" : '') .
                'Sol·licitud rebutjada el ' . now()->format('d/m/Y H:i') . ' per ' . Auth::user()->nom;
            $premiReclamat->save();

            // Registrar actividad
            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
                    'action' => 'Ha rebutjat la sol·licitud de premi #' . $premiReclamat->id . ' per a ' . $premiReclamat->user->nom
                ]);
            }
        });

        return response()->json(['success' => true]);
    }
}