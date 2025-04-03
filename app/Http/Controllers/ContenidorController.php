<?php
namespace App\Http\Controllers;

use App\Models\Contenidor;
use Illuminate\Http\Request;

class ContenidorController extends Controller
{
    public function index()
    {
        $contenidors = Contenidor::all();
        return response()->json($contenidors);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipus' => 'required|string|max:255',
            'ubicacio' => 'required|string|max:255',
        ]);

        $contenidor = Contenidor::create($validated);
        return response()->json($contenidor, 201);
    }

    public function show($id)
    {
        $contenidor = Contenidor::findOrFail($id);
        return response()->json($contenidor);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tipus' => 'sometimes|string|max:255',
            'ubicacio' => 'sometimes|string|max:255',
        ]);

        $contenidor = Contenidor::findOrFail($id);
        $contenidor->update($validated);
        return response()->json($contenidor);
    }

    public function destroy($id)
    {
        $contenidor = Contenidor::findOrFail($id);
        $contenidor->delete();
        return response()->json(['message' => 'Contenidor eliminat correctament']);
    }
}