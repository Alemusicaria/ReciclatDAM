<?php

namespace App\Http\Controllers;

use App\Models\Producte;
use Illuminate\Http\Request;

class ProducteController extends Controller
{
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
            'categoria' => 'required|string|in:Deixalleria,Envasos,Especial,Medicaments,Organica,Paper,Piles,RAEE,Resta,Vidre', // Valors del camp enum
            'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Imatge opcional
        ]);

        $producte = new Producte($validated);

        // Si hi ha una imatge, desa-la al directori corresponent
        if ($request->hasFile('imatge')) {
            $categoria = $validated['categoria'];

            // Defineix el directori on es desarà la imatge
            $directori = public_path("images/Reciclatge/{$categoria}");

            // Crea el directori si no existeix
            if (!file_exists($directori)) {
                mkdir($directori, 0755, true);
            }

            // Genera el nom de la imatge basat en el nom del producte
            $nomImatge = str_replace(' ', '_', $validated['nom']) . '.' . $request->file('imatge')->getClientOriginalExtension();

            // Desa la imatge al directori especificat
            $request->file('imatge')->move($directori, $nomImatge);

            // Desa el path de la imatge a la base de dades
            $producte->imatge = "images/Reciclatge/{$categoria}/{$nomImatge}";
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
            'categoria' => 'sometimes|string|in:Deixalleria,Envasos,Especial,Medicaments,Organica,Paper,Piles,RAEE,Resta,Vidre', // Valors del camp enum
            'imatge' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Imatge opcional
        ]);

        $producte = Producte::findOrFail($id);

        // Si hi ha una nova imatge, desa-la al directori corresponent
        if ($request->hasFile('imatge')) {
            // Elimina la imatge antiga si existeix usando Storage facade (más seguro que unlink)
            if ($producte->imatge) {
                // Asegurar que solo se eliminen paths dentro de la carpeta pública/images
                $imagePath = $producte->imatge;
                if (strpos($imagePath, 'images/') === 0) {
                    if (file_exists(public_path($imagePath))) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('images/', 'public/', $imagePath));
                    }
                }
            }

            // Obté la categoria actual o la nova
            $categoria = isset($validated['categoria']) ? $validated['categoria'] : $producte->categoria;

            // Defineix el directori on es desarà la nova imatge
            $directori = public_path("images/Reciclatge/{$categoria}");

            // Crea el directori si no existeix
            if (!file_exists($directori)) {
                mkdir($directori, 0755, true);
            }

            // Genera el nom de la imatge basat en el nom del producte - usar timestamp per a evitar collisions
            $timestamp = time() . '_';
            $nomImatge = $timestamp . str_replace(' ', '_', $validated['nom'] ?? $producte->nom) . '.' . $request->file('imatge')->getClientOriginalExtension();

            // Valida el nom de la imatge
            if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $nomImatge)) {
                return back()->with('error', 'Nom de imatge invàlid.');
            }

            // Desa la nova imatge al directori especificat
            $request->file('imatge')->move($directori, $nomImatge);

            // Desa el nou path de la imatge a la base de dades
            $producte->imatge = "images/Reciclatge/{$categoria}/{$nomImatge}";
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
        if ($producte->imatge && file_exists(public_path($producte->imatge))) {
            unlink(public_path($producte->imatge));
        }

        $producte->delete();

        return redirect()->route('productes.index')->with('success', 'Producte eliminat correctament.');
    }
}