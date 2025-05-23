<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rols = Rol::withCount('users')->get();
        return view('rols.index', compact('rols'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rols.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:50|unique:rols,nom',
            ]);

            $rol = Rol::create($validatedData);

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha creat un nou rol: ' . $rol->nom
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rol creat correctament',
                    'rol' => $rol
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Rol creat correctament');
        } catch (\Exception $e) {
            Log::error('Error al crear rol: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->withErrors(['error' => 'Error al crear el rol: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rol $rol)
    {
        $rol->loadCount('users');
        $usersWithRol = User::where('rol_id', $rol->id)->take(10)->get();
        return view('rols.show', compact('rol', 'usersWithRol'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rol $rol)
    {
        return view('rols.edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rol $rol)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:50|unique:rols,nom,' . $rol->id,
            ]);

            $rol->update($validatedData);

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha actualitzat el rol: ' . $rol->nom
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rol actualitzat correctament',
                    'rol' => $rol
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Rol actualitzat correctament');
        } catch (\Exception $e) {
            Log::error('Error al actualitzar rol: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->withErrors(['error' => 'Error al actualitzar el rol: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rol $rol)
    {
        try {
            $rolName = $rol->nom;
            
            // Verificar si hay usuarios con este rol antes de eliminar
            if ($rol->users()->count() > 0) {
                throw new \Exception('No es pot eliminar aquest rol perquè hi ha usuaris que el tenen assignat');
            }
            
            $rol->delete();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha eliminat el rol: ' . $rolName
                ]);
            }

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rol eliminat correctament'
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Rol eliminat correctament');
        } catch (\Exception $e) {
            Log::error('Error al eliminar rol: ' . $e->getMessage());
            
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Error al eliminar el rol: ' . $e->getMessage()]);
        }
    }
}