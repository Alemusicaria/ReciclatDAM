<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipusEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Log;

class TipusEventController extends Controller
{
    /**
     * Buscar tipos de eventos con Algolia
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $results = TipusEvent::search($query)->get();
        
        return response()->json($results);
    }
    
    /**
     * Lista todos los tipos de eventos
     */
    public function index()
    {
        $tipusEvents = TipusEvent::withCount('events')->get();
        return view('tipus_events.index', compact('tipusEvents'));
    }
    
    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('tipus_events.create');
    }
    
    /**
     * Almacenar nuevo tipo de evento
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'descripcio' => 'nullable|string',
                'color' => 'required|string|max:7',
            ]);
            
            $tipusEvent = TipusEvent::create($validatedData);
            
            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha creat un nou tipus d\'event: ' . $tipusEvent->nom
                ]);
            }
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipus d\'event creat correctament',
                    'tipusEvent' => $tipusEvent
                ]);
            }
            
            return redirect()->route('admin.dashboard')->with('success', 'Tipus d\'event creat correctament');
        } catch (\Exception $e) {
            Log::error('Error al crear tipus d\'event: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->withErrors(['error' => 'Error al crear el tipus d\'event: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Mostrar detalles de un tipo de evento
     */
    public function show(TipusEvent $tipusEvent)
    {
        $tipusEvent->loadCount('events');
        return view('tipus_events.show', compact('tipusEvent'));
    }
    
    /**
     * Mostrar formulario de edición
     */
    public function edit(TipusEvent $tipusEvent)
    {
        return view('tipus_events.edit', compact('tipusEvent'));
    }
    
    /**
     * Actualizar tipo de evento
     */
    public function update(Request $request, TipusEvent $tipusEvent)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'descripcio' => 'nullable|string',
                'color' => 'required|string|max:7',
            ]);
            
            $tipusEvent->update($validatedData);
            
            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha actualitzat el tipus d\'event: ' . $tipusEvent->nom
                ]);
            }
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipus d\'event actualitzat correctament',
                    'tipusEvent' => $tipusEvent
                ]);
            }
            
            return redirect()->route('admin.dashboard')->with('success', 'Tipus d\'event actualitzat correctament');
        } catch (\Exception $e) {
            Log::error('Error al actualitzar tipus d\'event: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->withErrors(['error' => 'Error al actualitzar el tipus d\'event: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Eliminar tipo de evento
     */
    public function destroy(TipusEvent $tipusEvent)
    {
        try {
            $tipusEventNom = $tipusEvent->nom;
            
            // Verificar si hay eventos que usan este tipo
            if ($tipusEvent->events()->count() > 0) {
                throw new \Exception('No es pot eliminar aquest tipus d\'event perquè hi ha events que l\'utilitzen');
            }
            
            $tipusEvent->delete();
            
            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha eliminat el tipus d\'event: ' . $tipusEventNom
                ]);
            }
            
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipus d\'event eliminat correctament'
                ]);
            }
            
            return redirect()->route('admin.dashboard')->with('success', 'Tipus d\'event eliminat correctament');
        } catch (\Exception $e) {
            Log::error('Error al eliminar tipus d\'event: ' . $e->getMessage());
            
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Error al eliminar el tipus d\'event: ' . $e->getMessage()]);
        }
    }
}