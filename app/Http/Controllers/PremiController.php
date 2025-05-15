<?php
namespace App\Http\Controllers;

use App\Models\Premi;
use App\Models\PremiReclamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PremiController extends Controller
{
    public function index()
    {
        $premis = Premi::all();
        return view('premis.index', compact('premis'));
    }

    public function create()
    {
        return view('premis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'descripcio' => 'required',
            'punts_requerits' => 'required|integer',
            'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Gestionar la pujada de la imatge
        if ($request->hasFile('imatge')) {
            $file = $request->file('imatge');
            $baseFilename = str_replace(' ', '_', strtolower($request->nom)); // Nom del premi com a base
            $extension = $file->getClientOriginalExtension();
            $filename = $baseFilename . '.' . $extension;

            // Comprovar si ja existeix una imatge amb el mateix nom
            $counter = 1;
            while (file_exists(public_path('images/Premis/' . $filename))) {
                $filename = $baseFilename . '_' . $counter . '.' . $extension;
                $counter++;
            }

            $file->move(public_path('images/Premis'), $filename);
            $data['imatge'] = 'images/Premis/' . $filename;
        }

        Premi::create($data);
        return redirect()->route('premis.index');
    }

    public function show(Premi $premi)
    {
        return view('premis.show', compact('premi'));
    }

    public function edit(Premi $premi)
    {
        return view('premis.edit', compact('premi'));
    }

    public function update(Request $request, Premi $premi)
    {
        $request->validate([
            'nom' => 'required',
            'descripcio' => 'required',
            'punts_requerits' => 'required|integer',
            'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Gestionar la pujada de la imatge
        if ($request->hasFile('imatge')) {
            // Esborrar la imatge antiga si existeix
            if ($premi->imatge && file_exists(public_path($premi->imatge))) {
                unlink(public_path($premi->imatge));
            }

            $file = $request->file('imatge');
            $baseFilename = str_replace(' ', '_', strtolower($request->nom)); // Nom del premi com a base
            $extension = $file->getClientOriginalExtension();
            $filename = $baseFilename . '.' . $extension;

            // Comprovar si ja existeix una imatge amb el mateix nom
            $counter = 1;
            while (file_exists(public_path('images/Premis/' . $filename))) {
                $filename = $baseFilename . '_' . $counter . '.' . $extension;
                $counter++;
            }

            $file->move(public_path('images/Premis'), $filename);
            $data['imatge'] = 'images/Premis/' . $filename;
        }

        $premi->update($data);
        return redirect()->route('premis.index');
    }

    public function destroy(Premi $premi)
    {
        $premi->delete();
        return redirect()->route('premis.index');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $premis = Premi::search($query)->get();

        return view('premis.search', compact('premis', 'query'));
    }
    public function canjear($id, Request $request)
    {
        try {
            $premi = Premi::findOrFail($id);
            $user = Auth::user();

            // Verificar puntos
            if ($user->punts_actuals < $premi->punts_requerits) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tens suficients punts'
                ], 400);
            }

            // Registrar canje
            $premiReclamat = new PremiReclamat();
            $premiReclamat->user_id = $user->id;
            $premiReclamat->premi_id = $premi->id;
            $premiReclamat->punts_gastats = $premi->punts_requerits;
            $premiReclamat->data_reclamacio = now();
            $premiReclamat->estat = 'pendent';
            $premiReclamat->save();

            // Actualizar puntos
            $user->punts_actuals -= $premi->punts_requerits;
            $user->punts_gastats += $premi->punts_requerits;
            $user->save();

            // Devolver respuesta JSON
            return response()->json([
                'success' => true,
                'message' => 'Premi reclamat correctament!',
                'punts_actuals' => $user->punts_actuals,
                'punts_gastats' => $user->punts_gastats,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en canje: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Hi ha hagut un error en processar la teva sol·licitud: ' . $e->getMessage()
            ], 500);
        }
    }
}