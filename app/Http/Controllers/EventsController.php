<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\TipusEvent;
use Carbon\Carbon;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    /**
     * Mostrar el calendario de eventos
     */
    public function index()
    {
        $tipusEvents = TipusEvent::all();

        // Si el usuario está autenticado, obtener sus eventos registrados
        $userEvents = [];
        if (Auth::check()) {
            $userEvents = DB::table('event_user')
                ->where('user_id', Auth::id())
                ->pluck('event_id')
                ->toArray();
        }

        if (!view()->exists('events')) {
            return redirect()->route('dashboard')->with('info', 'La vista pública d\'events no està disponible.');
        }

        return view('events', compact('tipusEvents', 'userEvents'));
    }

    /**
     * Obtener eventos para el calendario (JSON para FullCalendar)
     */
    public function getEvents(Request $request)
    {
        $query = Event::with('tipus')->withCount('participants');

        if ($request->filled('start')) {
            $query->where('data_inici', '>=', $request->input('start'));
        }

        if ($request->filled('end')) {
            $query->where('data_inici', '<=', $request->input('end'));
        }

        $events = $query->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => e($event->nom),
                    'start' => $event->data_inici ? $event->data_inici->format('Y-m-d H:i:s') : null,
                    'end' => $event->data_fi ? $event->data_fi->format('Y-m-d H:i:s') : null,
                    'color' => $event->tipus->color ?? '#3788d8',
                    'description' => e($event->descripcio),
                    'location' => e($event->lloc),
                    'extendedProps' => [
                        'tipus' => $event->tipus ? e($event->tipus->nom) : null,
                        'capacitat' => $event->capacitat,
                        'punts_disponibles' => $event->punts_disponibles,
                        'participants' => $event->participants_count,
                        'imatge' => e($event->imatge)
                    ]
                ];
            });

        return response()->json($events);
    }

    /**
     * Buscar eventos con Algolia
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $tipusFilter = $request->input('tipus');
        $dateFilter = $request->input('date_filter', 'all');

        $filters = [];

        // Filtrar por tipo de evento
        if ($tipusFilter) {
            $filters[] = "tipus_event_id:$tipusFilter";
        }

        // Filtrar por fecha
        if ($dateFilter === 'future') {
            $now = Carbon::now()->format('Y-m-d H:i:s');
            $filters[] = "data_inici_formatted >= $now";
        } elseif ($dateFilter === 'past') {
            $now = Carbon::now()->format('Y-m-d H:i:s');
            $filters[] = "data_inici_formatted < $now";
        }

        // Convertir array de filtros a string de Algolia
        $filterString = implode(' AND ', $filters);

        // Realizar búsqueda
        $results = Event::search($query)->when($filterString, function ($query) use ($filterString) {
            $query->filters($filterString);
        })->get();

        return response()->json($results);
    }

    /**
     * Mostrar detalles de un evento
     */
    public function show($id)
    {
        $event = Event::with(['tipus', 'participants'])->findOrFail($id);

        if (!view()->exists('events.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall d\'events no està disponible.');
        }

        return view('events.show', compact('event'));
    }

    /** 
     * Registrar al usuario actual en un evento
     */
    public function register(Request $request, $id)
    {
        $response = DB::transaction(function () use ($id, $request) {
            $event = Event::query()->with('tipus')->whereKey($id)->lockForUpdate()->firstOrFail();

            // Verificar si ya está registrado
            if ($event->participants()->where('user_id', Auth::id())->exists()) {
                return response()->json([
                    'success' => false,
                    'registered' => true,
                    'event' => [
                        'title' => e($event->nom),
                        'date' => $event->data_inici ? $event->data_inici->format('d/m/Y') : null,
                        'time' => $event->data_inici ? $event->data_inici->format('H:i') : null
                    ],
                    'html' => '
                        <div class="alert alert-success mt-2 small">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                                <div>
                                    <strong>¡Fantàstic!</strong> 
                                    <p class="mb-0">Ja formes part d\'aquest event! T\'esperem el dia ' . ($event->data_inici ? $event->data_inici->format('d/m/Y') : '') . ' a les ' . ($event->data_inici ? $event->data_inici->format('H:i') : '') . '.</p>
                                </div>
                            </div>
                        </div>'
                ]);
            }

            // Verificar disponibilidad - solo si capacitat NO es NULL
            if ($event->capacitat !== null && $event->participants()->count() >= $event->capacitat) {
                return response()->json([
                    'success' => false,
                    'full' => true,
                    'html' => '
                        <div class="alert alert-warning mt-2 small">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                                </div>
                                <div>
                                    <strong>Ho sentim!</strong> 
                                    <p class="mb-0">Aquest event ja ha arribat a la seva capacitat màxima.</p>
                                </div>
                            </div>
                        </div>'
                ]);
            }

            // Registrar al usuario
            $event->participants()->attach(Auth::id(), [
                'punts' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Volver a indexar el evento en Algolia para actualizar la información de participantes
            $event->searchable();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'registered' => true,
                    'event' => [
                        'title' => e($event->nom),
                        'date' => $event->data_inici ? $event->data_inici->format('d/m/Y') : null,
                        'time' => $event->data_inici ? $event->data_inici->format('H:i') : null
                    ],
                    'html' => '
                        <div class="alert alert-success mt-2 small">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                                <div>
                                    <strong>¡Fantàstic!</strong> 
                                    <p class="mb-0">T\'has registrat correctament a l\'event! T\'esperem el dia ' . ($event->data_inici ? $event->data_inici->format('d/m/Y') : '') . ' a les ' . ($event->data_inici ? $event->data_inici->format('H:i') : '') . '.</p>
                                </div>
                            </div>
                        </div>'
                ]);
            }

            return back()->with('success', 'T\'has registrat correctament a l\'event!');
        }, 3);

        return $response;
    }
    /**
     * Verificar si el usuario está registrado en un evento
     */
    public function checkRegistration($id)
    {
        $event = Event::findOrFail($id);

        // Verificar si está registrado
        $isRegistered = $event->participants()->where('user_id', Auth::id())->exists();

        // Verificar si está lleno
        $isFull = $event->capacitat !== null && $event->participants()->count() >= $event->capacitat;

        // Preparar mensajes HTML según el estado
        $html = '';

        if ($isRegistered) {
            $html = '
                <div class="alert alert-success mt-2 small">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div>
                            <strong>¡Fantàstic!</strong> 
                            <p class="mb-0">Ja formes part d\'aquest event! T\'esperem el dia ' . ($event->data_inici ? $event->data_inici->format('d/m/Y') : '') . ' a les ' . ($event->data_inici ? $event->data_inici->format('H:i') : '') . '.</p>
                        </div>
                    </div>
                </div>';
        } elseif ($isFull) {
            $html = '
                <div class="alert alert-warning mt-2 small">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                        </div>
                        <div>
                            <strong>Ho sentim!</strong> 
                            <p class="mb-0">Aquest event ja ha arribat a la seva capacitat màxima.</p>
                        </div>
                    </div>
                </div>';
        }

        return response()->json([
            'registered' => $isRegistered,
            'full' => $isFull,
            'html' => $html,
            'event' => [
                'title' => e($event->nom),
                'date' => $event->data_inici->format('d/m/Y'),
                'time' => $event->data_inici->format('H:i')
            ]
        ]);
    }
    /**
     * Mostrar el formulario para crear un nuevo evento
     */
    public function create()
    {
        $tipusEvents = TipusEvent::all();
        return view('events.create', compact('tipusEvents'));
    }

    /**
     * Almacenar un nuevo evento
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'descripcio' => 'nullable|string',
                'data_inici' => 'required|date',
                'data_fi' => 'required|date|after_or_equal:data_inici',
                'lloc' => 'nullable|string|max:255',
                'tipus_event_id' => 'required|exists:tipus_events,id',
                'capacitat' => 'nullable|integer|min:0',
                'punts_disponibles' => 'nullable|integer|min:0',
                'actiu' => 'nullable|boolean',
                'imatge' => 'nullable|image|max:2048',
            ]);

            $event = new Event();
            $event->nom = $validated['nom'];
            $event->descripcio = $validated['descripcio'];
            $event->data_inici = $validated['data_inici'];
            $event->data_fi = $validated['data_fi'];
            $event->lloc = $validated['lloc'];
            $event->tipus_event_id = $validated['tipus_event_id'];
            $event->capacitat = $validated['capacitat'];
            $event->punts_disponibles = $validated['punts_disponibles'] ?? 0;
            $event->actiu = isset($validated['actiu']) ? true : false;

            if ($request->hasFile('imatge')) {
                $path = $request->file('imatge')->store('events', 'public');
                $event->imatge = $path;
            }

            $event->save();

            // Registrar actividad
            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
                    'action' => 'Ha creat un nou event: ' . $event->nom
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event creat correctament',
                    'event' => $event
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Event creat correctament');
        } catch (\Exception $e) {
            Log::error('Error al crear l\'event: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No s\'ha pogut crear l\'event.'
                ], 422);
            }

            return back()->withErrors(['error' => 'No s\'ha pogut crear l\'event.']);
        }
    }

    /**
     * Mostrar el formulario para editar un evento
     */
    public function edit(Event $event)
    {
        $tipusEvents = TipusEvent::all();
        return view('events.edit', compact('event', 'tipusEvents'));
    }

    /**
     * Actualizar un evento
     */
    public function update(Request $request, Event $event)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'descripcio' => 'nullable|string',
                'data_inici' => 'required|date',
                'data_fi' => 'required|date|after_or_equal:data_inici',
                'lloc' => 'nullable|string|max:255',
                'tipus_event_id' => 'required|exists:tipus_events,id',
                'capacitat' => 'nullable|integer|min:0',
                'punts_disponibles' => 'nullable|integer|min:0',
                'actiu' => 'nullable|boolean',
                'imatge' => 'nullable|image|max:2048',
            ]);

            $event->nom = $validated['nom'];
            $event->descripcio = $validated['descripcio'];
            $event->data_inici = $validated['data_inici'];
            $event->data_fi = $validated['data_fi'];
            $event->lloc = $validated['lloc'];
            $event->tipus_event_id = $validated['tipus_event_id'];
            $event->capacitat = $validated['capacitat'];
            $event->punts_disponibles = $validated['punts_disponibles'] ?? 0;
            $event->actiu = isset($validated['actiu']) ? true : false;

            if ($request->hasFile('imatge')) {
                // Eliminar imagen anterior si existe
                if ($event->imatge) {
                    Storage::disk('public')->delete($event->imatge);
                }

                $path = $request->file('imatge')->store('events', 'public');
                $event->imatge = $path;
            }

            $event->save();

            // Registrar actividad
            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
                    'action' => 'Ha actualitzat l\'event: ' . $event->nom
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event actualitzat correctament',
                    'event' => $event
                ]);
            }

            return redirect()->route('admin.events.show', $event->id)->with('success', 'Event actualitzat correctament');
        } catch (\Exception $e) {
            Log::error('Error al actualitzar l\'event: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No s\'ha pogut actualitzar l\'event.'
                ], 500);
            }

            return back()->withErrors(['error' => 'No s\'ha pogut actualitzar l\'event.']);
        }
    }

    /**
     * Eliminar un evento
     */
    public function destroy(Event $event)
    {
        try {
            $eventName = $event->nom; // Guardar el nombre antes de eliminar

            // Eliminar imagen si existe
            if ($event->imatge) {
                Storage::disk('public')->delete($event->imatge);
            }

            $event->delete();

            // Registrar actividad
            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
                    'action' => 'Ha eliminat l\'event: ' . $eventName
                ]);
            }

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event eliminat correctament'
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Event eliminat correctament');
        } catch (\Exception $e) {
            Log::error('Error al eliminar l\'event: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No s\'ha pogut eliminar l\'event.'
                ], 500);
            }

            return back()->withErrors(['error' => 'No s\'ha pogut eliminar l\'event.']);
        }
    }
}