<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\TipusEvent;
use Carbon\Carbon;
use Auth;

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
            $userEvents = Auth::user()->events()->pluck('events.id')->toArray();
        }

        return view('events', compact('tipusEvents', 'userEvents'));
    }

    /**
     * Obtener eventos para el calendario (JSON para FullCalendar)
     */
    public function getEvents(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $events = Event::with('tipus')
            ->where('data_inici', '>=', $start)
            ->where('data_inici', '<=', $end)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->nom,
                    'start' => $event->data_inici->format('Y-m-d H:i:s'),
                    'end' => $event->data_fi ? $event->data_fi->format('Y-m-d H:i:s') : null,
                    'color' => $event->tipus->color ?? '#3788d8',
                    'description' => $event->descripcio,
                    'location' => $event->lloc,
                    'extendedProps' => [
                        'tipus' => $event->tipus ? $event->tipus->nom : null,
                        'capacitat' => $event->capacitat,
                        'punts_disponibles' => $event->punts_disponibles,
                        'participants' => $event->participants()->count(),
                        'imatge' => $event->imatge
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
        return view('events.show', compact('event'));
    }

    /** 
     * Registrar al usuario actual en un evento
     */
    public function register(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Verificar si ya está registrado
        if ($event->participants()->where('user_id', auth()->id())->exists()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'registered' => true,
                    'event' => [
                        'title' => $event->nom,
                        'date' => $event->data_inici->format('d/m/Y'),
                        'time' => $event->data_inici->format('H:i')
                    ],
                    'html' => '
                        <div class="alert alert-success mt-2 small">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                                <div>
                                    <strong>¡Fantàstic!</strong> 
                                    <p class="mb-0">Ja formes part d\'aquest event! T\'esperem el dia ' . $event->data_inici->format('d/m/Y') . ' a les ' . $event->data_inici->format('H:i') . '.</p>
                                </div>
                            </div>
                        </div>'
                ]);
            }
            return back()->with('error', '✓ Ja formes part d\'aquest event! T\'esperem el dia ' . $event->data_inici->format('d/m/Y'));
        }

        // Verificar disponibilidad - solo si capacitat NO es NULL
        if ($event->capacitat !== null && $event->participants()->count() >= $event->capacitat) {
            if ($request->expectsJson()) {
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
            return back()->with('error', 'Aquest event ja ha arribat a la seva capacitat màxima.');
        }

        // Registrar al usuario
        $event->participants()->attach(auth()->id(), [
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
                    'title' => $event->nom,
                    'date' => $event->data_inici->format('d/m/Y'),
                    'time' => $event->data_inici->format('H:i')
                ],
                'html' => '
                    <div class="alert alert-success mt-2 small">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <div>
                                <strong>¡Fantàstic!</strong> 
                                <p class="mb-0">T\'has registrat correctament a l\'event! T\'esperem el dia ' . $event->data_inici->format('d/m/Y') . ' a les ' . $event->data_inici->format('H:i') . '.</p>
                            </div>
                        </div>
                    </div>'
            ]);
        }
        return back()->with('success', 'T\'has registrat correctament a l\'event!');
    }
    /**
     * Verificar si el usuario está registrado en un evento
     */
    public function checkRegistration($id)
    {
        $event = Event::findOrFail($id);

        // Verificar si está registrado
        $isRegistered = $event->participants()->where('user_id', auth()->id())->exists();

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
                            <p class="mb-0">Ja formes part d\'aquest event! T\'esperem el dia ' . $event->data_inici->format('d/m/Y') . ' a les ' . $event->data_inici->format('H:i') . '.</p>
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
                'title' => $event->nom,
                'date' => $event->data_inici->format('d/m/Y'),
                'time' => $event->data_inici->format('H:i')
            ]
        ]);
    }
}