<?php
namespace App\Http\Controllers;

use App\Mail\PrizeClaimedMail;
use App\Models\Premi;
use App\Models\PremiReclamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PremiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['index', 'show', 'search', 'canjear']);
        $this->middleware('auth')->only(['index', 'show', 'search', 'canjear']);
    }

    public function index()
    {
        return redirect()->to(route('dashboard') . '#premis');
    }

    public function create()
    {
        if (!view()->exists('premis.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació de premis no està disponible.');
        }
        return view('premis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'descripcio' => 'required',
            'punts_requerits' => 'required|integer',
            'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'nom' => $validated['nom'],
            'descripcio' => $validated['descripcio'],
            'punts_requerits' => $validated['punts_requerits'],
        ];

        // Gestionar la pujada de la imatge
        if ($request->hasFile('imatge')) {
            $data['imatge'] = $request->file('imatge')->store('premis', 'public');
        }

        Premi::create($data);
        return redirect()->route('premis.index');
    }

    public function show(Premi $premi)
    {
        if (!view()->exists('premis.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall de premis no està disponible.');
        }
        return view('premis.show', compact('premi'));
    }

    public function edit(Premi $premi)
    {
        if (!view()->exists('premis.edit')) {
            return redirect()->route('dashboard')->with('info', 'La vista d\'edició de premis no està disponible.');
        }
        return view('premis.edit', compact('premi'));
    }

    public function update(Request $request, Premi $premi)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'descripcio' => 'required',
            'punts_requerits' => 'required|integer',
            'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'nom' => $validated['nom'],
            'descripcio' => $validated['descripcio'],
            'punts_requerits' => $validated['punts_requerits'],
        ];

        // Gestionar la pujada de la imatge
        if ($request->hasFile('imatge')) {
            // Esborrar la imatge antiga si existeix
            if ($premi->imatge) {
                if (Storage::disk('public')->exists($premi->imatge)) {
                    Storage::disk('public')->delete($premi->imatge);
                } elseif (file_exists(public_path($premi->imatge))) {
                    @unlink(public_path($premi->imatge));
                }
            }

            $data['imatge'] = $request->file('imatge')->store('premis', 'public');
        }

        $premi->update($data);
        return redirect()->route('premis.index');
    }

    public function destroy(Premi $premi)
    {
        if ($premi->imatge) {
            if (Storage::disk('public')->exists($premi->imatge)) {
                Storage::disk('public')->delete($premi->imatge);
            } elseif (file_exists(public_path($premi->imatge))) {
                @unlink(public_path($premi->imatge));
            }
        }

        $premi->delete();
        return redirect()->route('premis.index');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $premis = Premi::search($query)->get();

        if (!view()->exists('premis.search')) {
            return redirect()->route('dashboard')->with('info', 'La vista de cerca de premis no està disponible.');
        }

        return view('premis.search', compact('premis', 'query'));
    }
    public function canjear($id, Request $request)
    {
        try {
            return DB::transaction(function () use ($id) {
                $premi = Premi::findOrFail($id);
                $user = Auth::user();
                $lockedUser = \App\Models\User::query()->whereKey($user->id)->lockForUpdate()->firstOrFail();

                // Verificar puntos
                if ($lockedUser->punts_actuals < $premi->punts_requerits) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No tens suficients punts'
                    ], 400);
                }

                // Registrar canje
                $premiReclamat = new PremiReclamat();
                $premiReclamat->user_id = $lockedUser->id;
                $premiReclamat->premi_id = $premi->id;
                $premiReclamat->punts_gastats = $premi->punts_requerits;
                $premiReclamat->data_reclamacio = Carbon::now();
                $premiReclamat->estat = 'pendent';
                $premiReclamat->save();

                // Actualizar puntos
                $lockedUser->punts_actuals -= $premi->punts_requerits;
                $lockedUser->punts_gastats += $premi->punts_requerits;
                $lockedUser->save();

                if (
                    !app()->environment('testing')
                    && is_string($lockedUser->email)
                    && filter_var($lockedUser->email, FILTER_VALIDATE_EMAIL)
                ) {
                    Mail::to($lockedUser->email)->queue(new PrizeClaimedMail($lockedUser, $premi, $premiReclamat));
                }

                // Devolver respuesta JSON
                return response()->json([
                    'success' => true,
                    'message' => 'Premi reclamat correctament!',
                    'punts_actuals' => $lockedUser->punts_actuals,
                    'punts_gastats' => $lockedUser->punts_gastats,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error en canje: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Hi ha hagut un error en processar la teva sol·licitud.'
            ], 500);
        }
    }
}