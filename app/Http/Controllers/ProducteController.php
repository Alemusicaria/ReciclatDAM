<?php
namespace App\Http\Controllers;

use App\Models\Producte;
use Illuminate\Http\Request;

class ProducteController extends Controller
{
    public function index()
    {
        $productes = Producte::all();
        return response()->json($productes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
        ]);

        $producte = Producte::create($validated);
        return response()->json($producte, 201);
    }

    public function show($id)
    {
        $producte = Producte::findOrFail($id);
        return response()->json($producte);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'categoria' => 'sometimes|string|max:255',
        ]);

        $producte = Producte::findOrFail($id);
        $producte->update($validated);
        return response()->json($producte);
    }

    public function destroy($id)
    {
        $producte = Producte::findOrFail($id);
        $producte->delete();
        return response()->json(['message' => 'Producte eliminat correctament']);
    }
}