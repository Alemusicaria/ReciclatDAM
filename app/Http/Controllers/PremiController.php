<?php
namespace App\Http\Controllers;

use App\Models\Premi;
use Illuminate\Http\Request;

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
}