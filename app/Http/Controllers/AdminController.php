<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Premi;
use App\Models\Codi; // Mantenemos Codi si es el nombre correcto de tu modelo
use App\Models\PremiReclamat;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\TipusEvent;
use App\Models\PuntDeRecollida;
use App\Models\Producte;


class AdminController extends Controller
{
    public function index()
    {
        // Comprovar si l'usuari és admin
        if (auth()->user()->rol_id != 1) {
            return redirect()->route('home')->with('error', 'No tens permís per accedir al panell d\'administració.');
        }

        // Estadístiques bàsiques
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalPremis = Premi::count();
        $totalCodis = Codi::count();

        // Estadístiques mensuals
        $lastMonth = Carbon::now()->subMonth();

        $usersLastMonth = User::where('created_at', '<', $lastMonth)->count();
        $newUsersPercent = $usersLastMonth > 0
            ? round((User::whereBetween('created_at', [$lastMonth, Carbon::now()])->count() / $usersLastMonth) * 100)
            : 100;

        $codisLastMonth = Codi::where('data_escaneig', '<', $lastMonth)->count();
        $newCodisPercent = $codisLastMonth > 0
            ? round((Codi::whereBetween('data_escaneig', [$lastMonth, Carbon::now()])->count() / $codisLastMonth) * 100)
            : 100;

        // Events actius
        $activeEvents = Event::where('data_fi', '>=', Carbon::now())->count();

        // Premis pendents
        $pendingRewards = PremiReclamat::where('estat', 'pendent')->count();

        // Millors usuaris - SIN USAR with('nivell')
        $topUsers = User::where('rol_id', 2)
            ->orderBy('punts_totals', 'desc')
            ->take(5)
            ->get();

        // Activitat recent
        $recentActivities = Activity::with('user')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Distribució de punts
        $totalActivePoints = User::sum('punts_actuals');
        $totalSpentPoints = User::sum('punts_gastats');
        $totalEventPoints = DB::table('event_user')->sum('punts');

        // Dades per a gràfics - últims 6 mesos
        $months = collect([]);
        for ($i = 5; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i));
        }

        $activityChartLabels = $months->map(function ($month) {
            return $month->format('M Y');
        });

        $newUsersData = $months->map(function ($month) {
            $start = (clone $month)->startOfMonth();
            $end = (clone $month)->endOfMonth();
            return User::whereBetween('created_at', [$start, $end])->count();
        });

        $codisScannedData = $months->map(function ($month) {
            $start = (clone $month)->startOfMonth();
            $end = (clone $month)->endOfMonth();
            return Codi::whereBetween('data_escaneig', [$start, $end])->count();
        });

        $premisClaimedData = $months->map(function ($month) {
            $start = (clone $month)->startOfMonth();
            $end = (clone $month)->endOfMonth();
            return PremiReclamat::whereBetween('data_reclamacio', [$start, $end])->count();
        });

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEvents',
            'totalPremis',
            'totalCodis',
            'newUsersPercent',
            'newCodisPercent',
            'activeEvents',
            'pendingRewards',
            'topUsers',
            'recentActivities',
            'totalActivePoints',
            'totalSpentPoints',
            'totalEventPoints',
            'activityChartLabels',
            'newUsersData',
            'codisScannedData',
            'premisClaimedData'
        ));
    }
    // Obtener eventos en formato JSON para FullCalendar
    public function getEventsJson()
    {
        $events = Event::all();

        return response()->json($events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->nom,
                'start' => $event->data_inici,
                'end' => $event->data_fi,
                'backgroundColor' => $event->tipus ? $event->tipus->color : '#3788d8',
                'borderColor' => $event->tipus ? $event->tipus->color : '#3788d8',
                'textColor' => '#ffffff'
            ];
        }));
    }
    public function getModalContent($type)
    {
        try {
            switch ($type) {
                case 'users':
                    $users = User::with('rol')->latest()->get();
                    return view('admin.modals.users', compact('users'));

                case 'events':
                    $events = Event::with('tipus')->latest()->get();
                    return view('admin.modals.events', compact('events'));
                case 'premis':
                    $premis = Premi::with('premiReclamats.user')->orderBy('id', 'desc')->get();
                    return view('admin.modals.premis', compact('premis'));
                case 'codis':
                    $codis = Codi::with('user')->orderBy('id', 'desc')->get();
                    return view('admin.modals.codis', compact('codis'));
                case 'productes':
                    $productes = Producte::orderBy('id', 'desc')->get();
                    return view('admin.modals.productes', compact('productes'));

                case 'punt-reciclatge':
                    $punts = PuntDeRecollida::latest()->get();
                    return view('admin.modals.punt-reciclatge', compact('punts'));
                case 'tipus-events':
                    $tipusEvents = TipusEvent::latest()->get();
                    return view('admin.modals.tipus-events', compact('tipusEvents'));
                case 'premis-reclamats':
                    $premisReclamats = PremiReclamat::with('user', 'premi')->latest()->get();
                    return view('admin.modals.premis-reclamats', compact('premisReclamats'));
                case 'activitats':
                    $activitats = Activity::with('user')->latest()->get();
                    return view('admin.modals.activitats', compact('activitats'));
                default:
                    throw new \Exception('Modal no suportada');
            }
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }
    public function getCreateForm($type)
    {
        try {
            switch ($type) {
                case 'user':
                    return view('admin.create.user');

                case 'event':
                    $tipusEvents = TipusEvent::all();
                    return view('admin.create.event', compact('tipusEvents'));

                case 'premi':
                    return view('admin.create.premi');

                case 'codi':
                    $users = User::where('rol_id', 2)->get(); // Solo usuarios regulares
                    return view('admin.create.codi', compact('users'));

                default:
                    throw new \Exception('Formulario de creación no soportado');
            }
        } catch (\Exception $e) {
            \Log::error('Error en getCreateForm: ' . $e->getMessage());
            return '<div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Error al cargar el formulario: ' . $e->getMessage() . '
            </div>';
        }
    }
    public function getDetails($type, $id = null)
    {
        try {
            // Casos especiales para crear
            if ($type === 'create-premi') {
                return view('admin.create.premi');
            } elseif ($type === 'create-event') {
                $tipusEvents = TipusEvent::all();
                return view('admin.create.event', compact('tipusEvents'));
            } elseif ($type === 'create-user') {
                return view('admin.create.user');
            } elseif ($type === 'create-codi') {
                $users = User::where('rol_id', 2)->get(); // Solo usuarios regulares
                return view('admin.create.codi', compact('users'));
            } elseif ($type === 'create-producte') {
                return view('admin.create.producte');
            }

            // Casos regulares con ID
            switch ($type) {
                case 'user':
                    $user = User::findOrFail($id);
                    return view('admin.details.user', compact('user'));

                case 'event':
                    $event = Event::with(['tipus', 'participants'])->findOrFail($id);
                    return view('admin.details.event', compact('event'));

                case 'premi':
                    $premi = Premi::with('premiReclamats.user')->findOrFail($id);
                    return view('admin.details.premi', compact('premi'));

                case 'codi':
                    $codi = Codi::with('user')->findOrFail($id);
                    return view('admin.details.codi', compact('codi'));
                case 'producte':
                    $producte = Producte::findOrFail($id);
                    return view('admin.details.producte', compact('producte'));
                default:
                    throw new \Exception('Tipus de detall no suportat');
            }
        } catch (\Exception $e) {
            \Log::error('Error en getDetails: ' . $e->getMessage());
            return '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }

    public function getEditForm($type, $id)
    {
        try {
            switch ($type) {
                case 'user':
                    $user = User::findOrFail($id);
                    return view('admin.edit.user', compact('user'));

                case 'event':
                    $event = Event::findOrFail($id);
                    $tipusEvents = TipusEvent::all();
                    return view('admin.edit.event', compact('event', 'tipusEvents'));

                case 'premi':
                    $premi = Premi::findOrFail($id);
                    return view('admin.edit.premi', compact('premi'));

                case 'codi':
                    $codi = Codi::findOrFail($id);
                    $users = User::where('rol_id', 2)->get();
                    return view('admin.edit.codi', compact('codi', 'users'));

                case 'producte':
                    $producte = Producte::findOrFail($id);
                    return view('admin.edit.producte', compact('producte'));
                default:
                    throw new \Exception('Formulario de edición no soportado');
            }
        } catch (\Exception $e) {
            \Log::error('Error en getEditForm: ' . $e->getMessage());
            return '<div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Error al cargar el formulario: ' . $e->getMessage() . '
            </div>';
        }
    }
    // Actualizar detalles de un elemento
    public function updateDetails(Request $request, $type, $id)
    {
        try {
            switch ($type) {
                case 'user':
                    $item = User::findOrFail($id);
                    $validatedData = $request->validate([
                        'nom' => 'required|string|max:255',
                        'cognoms' => 'required|string|max:255',
                        'email' => 'required|email|unique:users,email,' . $id,
                        'data_naixement' => 'nullable|date',
                        'telefon' => 'nullable|string|max:20',
                        'ubicacio' => 'nullable|string|max:255',
                        'punts_actuals' => 'nullable|integer|min:0',
                        'punts_gastats' => 'nullable|integer|min:0',
                    ]);
                    break;

                case 'event':
                    $item = Event::findOrFail($id);
                    $validatedData = $request->validate([
                        'nom' => 'required|string|max:255',
                        'descripcio' => 'nullable|string',
                        'data_inici' => 'required|date',
                        'data_fi' => 'required|date|after_or_equal:data_inici',
                        'tipus_id' => 'nullable|exists:tipus_events,id',
                        'capacitat' => 'nullable|integer|min:0',
                        'ubicacio' => 'nullable|string|max:255',
                        'punts' => 'nullable|integer|min:0',
                    ]);
                    break;

                case 'premi':
                    $item = Premi::findOrFail($id);
                    $validatedData = $request->validate([
                        'nom' => 'required|string|max:255',
                        'descripcio' => 'nullable|string',
                        'punts_requerits' => 'required|integer|min:0',
                        'estoc' => 'nullable|integer|min:0',
                    ]);
                    break;

                case 'codi':
                    $item = Codi::findOrFail($id);
                    $validatedData = $request->validate([
                        'user_id' => 'nullable|exists:users,id',
                        'codi' => 'required|string|',
                        'punts' => 'required|integer|min:0',
                        'data_escaneig' => 'required|date',
                    ]);
                    break;

                case 'punt-reciclatge':
                    $item = PuntDeRecollida::findOrFail($id);
                    $validatedData = $request->validate([
                        'nom' => 'required|string|max:255',
                        'fraccio' => 'required|string',
                        'adreca' => 'required|string|max:255',
                        'ciutat' => 'required|string|max:255',
                        'latitud' => 'required|numeric',
                        'longitud' => 'required|numeric',
                        'descripcio' => 'nullable|string',
                    ]);
                    break;

                default:
                    throw new \Exception('Tipo de detalle no soportado');
            }

            $item->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Actualitzat correctament'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    // Eliminar detalles de un elemento
    public function destroyDetails($type, $id)
    {
        try {
            switch ($type) {
                case 'user':
                    $item = User::findOrFail($id);
                    $itemName = $item->nom . ' ' . $item->cognoms;

                    // Eliminar foto de perfil si existe y no es una URL externa
                    if ($item->foto_perfil && !str_starts_with($item->foto_perfil, 'https://')) {
                        if (Storage::disk('public')->exists($item->foto_perfil)) {
                            Storage::disk('public')->delete($item->foto_perfil);
                        }
                    }
                    break;

                case 'event':
                    $item = Event::findOrFail($id);
                    $itemName = $item->nom;
                    break;

                case 'codi':
                    $item = Codi::findOrFail($id);
                    $itemName = $item->codi;
                    break;

                case 'premi':
                    $item = Premi::findOrFail($id);
                    $itemName = $item->nom;
                    break;

                case 'punt-reciclatge':
                    $item = PuntDeRecollida::findOrFail($id);
                    $itemName = $item->nom;
                    break;
                case 'producte':
                    $item = Producte::findOrFail($id);
                    $itemName = $item->nom;

                    // Eliminar la imagen asociada si existe
                    if ($item->imatge && file_exists(public_path($item->imatge))) {
                        unlink(public_path($item->imatge));
                    }
                    break;
                default:
                    throw new \Exception('Tipus d\'element no suportat');
            }

            // Eliminar el elemento
            $item->delete();

            // Registrar actividad
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha eliminat ' . $type . ': ' . $itemName
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Element eliminat correctament'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar ' . $type . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}