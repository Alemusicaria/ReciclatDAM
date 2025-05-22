<?php
namespace App\Http\Controllers;

use App\Models\Codi;
use Illuminate\Http\Request;

class CodiController extends Controller
{
    public function index()
    {
        $codis = Codi::all();
        return view('codis.index', compact('codis'));
    }

    public function create()
    {
        return view('codis.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'codi' => 'required|string',
                'user_id' => 'nullable|exists:users,id',
                'punts' => 'required|integer|min:0',
                'data_escaneig' => 'required|date',
            ]);

            $codi = new Codi();
            $codi->codi = $validatedData['codi'];
            $codi->user_id = $validatedData['user_id'];
            $codi->punts = $validatedData['punts'];
            $codi->data_escaneig = $validatedData['data_escaneig'];
            $codi->save();

            if ($request->expectsJson() || $request->ajax()) {
                // Para peticiones AJAX/JSON, devolver respuesta simplificada
                return response()->json([
                    'success' => true
                ]);
            }

            // Para peticiones normales, redirigir
            return redirect()->route('admin.dashboard')->with('success', 'Codi creat correctament');

        } catch (\Exception $e) {
            \Log::error('Error al crear codi: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => 'Error al crear el codi: ' . $e->getMessage()]);
        }
    }

    public function show(Codi $codi)
    {
        return view('codis.show', compact('codi'));
    }

    public function edit(Codi $codi)
    {
        return view('codis.edit', compact('codi'));
    }

    public function update(Request $request, Codi $codi)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'codi' => 'required|unique:codis,codi,' . $codi->id,
            'punts' => 'required|integer',
            'data_escaneig' => 'required|date',
        ]);

        $codi->update($request->all());
        return redirect()->route('codis.index');
    }

    public function destroy(Codi $codi)
    {
        $codi->delete();
        return redirect()->route('codis.index');
    }
}