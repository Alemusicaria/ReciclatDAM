<?php

namespace App\Http\Controllers;

use App\Models\Producte;
use Illuminate\Http\Request;
use App\Support\UploadedFileSecurity;

class ProducteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->only(['create', 'store', 'edit', 'update', 'destroy']);
        $this->middleware('auth')->only(['index', 'show']);
    }

    // Llistar tots els productes
    public function index()
    {
        $productes = Producte::all();

        if (!view()->exists('productes.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista pública de productes no està disponible.');
        }

        return view('productes.index', compact('productes'));
    }

    // Mostrar el formulari per crear un nou producte
    public function create()
    {
        if (!view()->exists('productes.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació de productes no està disponible.');
        }

        return view('productes.create');
    }

    public function show($id)
    {
        $producte = Producte::findOrFail($id);

        if (!view()->exists('productes.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall de productes no està disponible.');
        }

        return view('productes.show', compact('producte'));
    }

    // Crear un nou producte
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categoria' => 'required|string|in:Deixalleria,Envasos,Especial,Medicaments,Organica,Paper,Piles,RAEE,Resta,Vidre',
            'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $producte = new Producte($validated);

        // Si hi ha una imatge, desa-la al directori corresponent
        if ($request->hasFile('imatge')) {
            $categoria = $validated['categoria'];
            $producte->imatge = UploadedFileSecurity::storeImage(
                $request->file('imatge'),
                "images/Reciclatge/{$categoria}"
            );
        }

        $producte->save();

        return redirect()->route('productes.index')->with('success', 'Producte creat correctament.');
    }

    // Mostrar el formulari per editar un producte existent
    public function edit($id)
    {
        $producte = Producte::findOrFail($id);

        if (!view()->exists('productes.edit')) {
            return redirect()->route('dashboard')->with('info', 'La vista d\'edició de productes no està disponible.');
        }

        return view('productes.edit', compact('producte'));
    }

    // Actualitzar un producte existent
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'categoria' => 'sometimes|string|in:Deixalleria,Envasos,Especial,Medicaments,Organica,Paper,Piles,RAEE,Resta,Vidre',
            'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $producte = Producte::findOrFail($id);

        // Si hi ha una nova imatge, desa-la al directori corresponent
        if ($request->hasFile('imatge')) {
            UploadedFileSecurity::deleteStoredFile($producte->imatge);

            $categoria = isset($validated['categoria']) ? $validated['categoria'] : $producte->categoria;
            $producte->imatge = UploadedFileSecurity::storeImage(
                $request->file('imatge'),
                "images/Reciclatge/{$categoria}"
            );
        }

        // Actualitza els altres camps del producte
        $producte->update($validated);

        return redirect()->route('productes.index')->with('success', 'Producte actualitzat correctament.');
    }

    // Eliminar un producte
    public function destroy($id)
    {
        $producte = Producte::findOrFail($id);

        // Elimina la imatge associada si existeix
        UploadedFileSecurity::deleteStoredFile($producte->imatge);

        $producte->delete();

        return redirect()->route('productes.index')->with('success', 'Producte eliminat correctament.');
    }
}