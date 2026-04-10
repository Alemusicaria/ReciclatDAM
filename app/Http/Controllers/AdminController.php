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
use App\Models\Rol;
use App\Models\TipusAlerta;
use App\Models\AlertaPuntDeRecollida;
use App\Models\Opinions;
use App\Models\NavigatorInfo;
use App\Services\AdminDashboardMetricsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{
    private const MODAL_MAX_RESULTS = 100;

    private const ALLOWED_MODAL_TYPES = [
        'users',
        'events',
        'premis',
        'codis',
        'productes',
        'punt-reciclatge',
        'rols',
        'alertes-punts',
        'tipus-alertes',
        'tipus-events',
        'premis-reclamats',
        'activitats',
        'users-ranking',
        'opinions',
    ];

    public function index(AdminDashboardMetricsService $metricsService)
    {
        $cachedStats = $metricsService->getDashboardStats();

        // Estadístiques bàsiques
        $totalUsers = $cachedStats['totalUsers'];
        $totalEvents = $cachedStats['totalEvents'];
        $totalPremis = $cachedStats['totalPremis'];
        $totalCodis = $cachedStats['totalCodis'];

        $monthlyPercentages = $metricsService->getMonthlyPercentages();
        $newUsersPercent = $monthlyPercentages['newUsersPercent'];
        $newCodisPercent = $monthlyPercentages['newCodisPercent'];
        $newEventsPercent = $monthlyPercentages['newEventsPercent'];

        // Events actius
        $activeEvents = $cachedStats['activeEvents'];

        // Premis pendents
        $pendingRewards = $cachedStats['pendingRewards'];

        $topUsers = User::select('id', 'nom', 'cognoms', 'email', 'punts_actuals')
            ->orderBy('punts_actuals', 'desc')
            ->limit(50)
            ->get();
        $topUsersForDistribution = $topUsers
            ->take(6)
            ->map(function ($user) {
                $fullName = trim(($user->nom ?? '') . ' ' . ($user->cognoms ?? ''));

                return [
                    'name' => $fullName !== '' ? $fullName : ($user->email ?? 'Usuari'),
                    'points' => (int) ($user->punts_actuals ?? 0),
                ];
            })
            ->values();
        $usersByLevel = DB::table('users')
            ->join('nivells', 'users.nivell_id', '=', 'nivells.id')
            ->select('nivells.nom', DB::raw('count(*) as total'))
            ->groupBy('nivells.nom')
            ->pluck('total', 'nom');

        // Colores para el gráfico de niveles
        $levelColors = [
            '#4CAF50',
            '#2196F3',
            '#FF9800',
            '#F44336',
            '#9C27B0',
            '#673AB7',
            '#3F51B5',
            '#009688'
        ];
        // Activitat recent
        $recentActivities = Activity::with('user')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Distribució de punts
        $totalActivePoints = $cachedStats['totalActivePoints'];
        $totalSpentPoints = $cachedStats['totalSpentPoints'];
        $totalEventPoints = $cachedStats['totalEventPoints'];
        $activitySeries = $metricsService->getActivitySeries(6);
        $activityChartLabels = $activitySeries['activityChartLabels'];
        $newUsersData = $activitySeries['newUsersData'];
        $codisScannedData = $activitySeries['codisScannedData'];
        $premisClaimedData = $activitySeries['premisClaimedData'];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEvents',
            'totalPremis',
            'totalCodis',
            'newUsersPercent',
            'newEventsPercent',
            'newCodisPercent',
            'activeEvents',
            'pendingRewards',
            'topUsers',
            'topUsersForDistribution',
            'recentActivities',
            'totalActivePoints',
            'totalSpentPoints',
            'totalEventPoints',
            'activityChartLabels',
            'newUsersData',
            'codisScannedData',
            'premisClaimedData',
            'usersByLevel',
            'levelColors'
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
            if (!in_array($type, self::ALLOWED_MODAL_TYPES, true)) {
                return response()->json([
                    'error' => 'Modal no suportada',
                ], 404);
            }

            switch ($type) {
                case 'users':
                    $users = User::with('rol')->latest()->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.users', compact('users'));

                case 'events':
                    $events = Event::with('tipus')->latest()->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.events', compact('events'));
                case 'premis':
                    $premis = Premi::with('premiReclamats.user')->orderBy('id', 'desc')->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.premis', compact('premis'));
                case 'codis':
                    $codis = Codi::with('user')->orderBy('id', 'desc')->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.codis', compact('codis'));
                case 'productes':
                    $productes = Producte::orderBy('id', 'desc')->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.productes', compact('productes'));
                case 'punt-reciclatge':
                    $punts = PuntDeRecollida::latest()->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.punt-reciclatge', compact('punts'));
                case 'rols':
                    $rols = Cache::remember('admin.modal.rols', now()->addMinutes(10), function () {
                        return Rol::orderBy('id', 'desc')->get();
                    });
                    return view('admin.modals.rols', compact('rols'));
                case 'alertes-punts':
                    $alertes = AlertaPuntDeRecollida::with('puntDeRecollida', 'tipus')->latest()->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.alertes-punts', compact('alertes'));
                case 'tipus-alertes':
                    $tipusAlertes = Cache::remember('admin.modal.tipus-alertes', now()->addMinutes(10), function () {
                        return TipusAlerta::with('alertes')->latest()->get();
                    });
                    return view('admin.modals.tipus-alertes', compact('tipusAlertes'));
                case 'tipus-events':
                    $tipusEvents = Cache::remember('admin.modal.tipus-events', now()->addMinutes(10), function () {
                        return TipusEvent::latest()->get();
                    });
                    return view('admin.modals.tipus-events', compact('tipusEvents'));
                case 'premis-reclamats':
                    $premisReclamats = PremiReclamat::with(['user', 'premi'])->latest()->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.premis-reclamats', compact('premisReclamats'));
                case 'activitats':
                    $activitats = Activity::with('user')->latest()->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.activitats', compact('activitats'));
                case 'users-ranking':
                    $users = User::orderBy('punts_totals', 'desc')->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.users-ranking', compact('users'));
                case 'opinions':
                    $opinions = Opinions::latest()->limit(self::MODAL_MAX_RESULTS)->get();
                    return view('admin.modals.opinions', compact('opinions'));
                default:
                    return response()->json([
                        'error' => 'Modal no suportada',
                    ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error en getModalContent: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error intern carregant el contingut del modal.',
            ], 500);
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
            Log::error('Error en getCreateForm: ' . $e->getMessage());
            return '<div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Error al carregar el formulari.
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
            } elseif ($type === 'create-punt-reciclatge') {
                return view('admin.create.punt-reciclatge');
            } elseif ($type === 'create-rol') {
                return view('admin.create.rol');
            } elseif ($type === 'create-alerta-punt') {
                $puntsDeRecollida = PuntDeRecollida::all();
                $tipusAlertes = TipusAlerta::all();
                return view('admin.create.alerta-punt', compact('puntsDeRecollida', 'tipusAlertes'));
            } elseif ($type === 'create-tipus-alerta') {
                return view('admin.create.tipus-alerta');
            } elseif ($type === 'create-tipus-event') {
                return view('admin.create.tipus-event');
            } elseif ($type === 'create-premi-reclamat') {
                $premis = Premi::all();
                $users = User::all();
                return view('admin.create.premi-reclamat', compact('premis', 'users'));
            } elseif ($type === 'create-activitat') {
                return view('admin.create.activitat');
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
                case 'punt-reciclatge':
                    $punt = PuntDeRecollida::findOrFail($id);
                    return view('admin.details.punt-reciclatge', compact('punt'));
                case 'rol':
                    $rol = Rol::findOrFail($id);
                    return view('admin.details.rol', compact('rol'));
                case 'alerta-punt':
                    $alerta = AlertaPuntDeRecollida::with('puntDeRecollida', 'tipus')->findOrFail($id);
                    return view('admin.details.alerta-punt', compact('alerta'));
                case 'tipus-alerta':
                    $tipusAlerta = TipusAlerta::findOrFail($id);
                    return view('admin.details.tipus-alerta', compact('tipusAlerta'));
                case 'tipus-event':
                    $tipusEvent = TipusEvent::findOrFail($id);
                    return view('admin.details.tipus-event', compact('tipusEvent'));
                case 'opinio':
                    $opinio = Opinions::findOrFail($id);
                    return view('admin.details.opinio', compact('opinio'));
                case 'premi-reclamat':
                    $premiReclamat = PremiReclamat::with(['user', 'premi'])->findOrFail($id);
                    return view('admin.details.premi-reclamat', compact('premiReclamat'));
                case 'activitat':
                    $activitat = Activity::with('user.rol')->findOrFail($id);
                    return view('admin.details.activitat', compact('activitat'));
                default:
                    throw new \Exception('Tipus de detall no suportat');
            }
        } catch (\Exception $e) {
            Log::error('Error en getDetails: ' . $e->getMessage());
            return '<div class="alert alert-danger">Error intern carregant els detalls.</div>';
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

                case 'punt-reciclatge':
                    $punt = PuntDeRecollida::findOrFail($id);
                    return view('admin.edit.punt-reciclatge', compact('punt'));

                case 'rol':
                    $rol = Rol::findOrFail($id);
                    return view('admin.edit.rol', compact('rol'));

                case 'alerta-punt':
                    $alerta = AlertaPuntDeRecollida::findOrFail($id);
                    $puntsDeRecollida = PuntDeRecollida::all();
                    $tipusAlertes = TipusAlerta::all();
                    return view('admin.edit.alerta-punt', compact('alerta', 'puntsDeRecollida', 'tipusAlertes'));

                case 'tipus-alerta':
                    $tipusAlerta = TipusAlerta::findOrFail($id);
                    return view('admin.edit.tipus-alerta', compact('tipusAlerta'));

                case 'tipus-event':
                    $tipusEvent = TipusEvent::findOrFail($id);
                    return view('admin.edit.tipus-event', compact('tipusEvent'));

                case 'premi-reclamat':
                    $premiReclamat = PremiReclamat::findOrFail($id);
                    return view('admin.edit.premi-reclamat', compact('premiReclamat'));

                case 'activitat':
                    $activitat = Activity::findOrFail($id);
                    return view('admin.edit.activitat', compact('activitat'));
                default:
                    throw new \Exception('Formulario de edición no soportado');
            }
        } catch (\Exception $e) {
            Log::error('Error en getEditForm: ' . $e->getMessage());
            return '<div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Error al carregar el formulari.
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

                case 'rol':
                    $item = Rol::findOrFail($id);
                    $validatedData = $request->validate([
                        'nom' => 'required|string|max:255',
                    ]);
                    break;

                case 'alerta-punt':
                    $item = AlertaPuntDeRecollida::findOrFail($id);
                    $validatedData = $request->validate([
                        'punt_de_recollida_id' => 'required|exists:punts_de_recollida,id',
                        'tipus_alerta_id' => 'required|exists:tipus_alertes,id',
                        'descripció' => 'required|string',
                    ]);
                    break;

                case 'tipus-alerta':
                    $item = TipusAlerta::findOrFail($id);
                    $validatedData = $request->validate([
                        'nom' => 'required|string|max:255',
                    ]);
                    break;

                case 'tipus-event':
                    $item = TipusEvent::findOrFail($id);
                    $validatedData = $request->validate([
                        'nom' => 'required|string|max:255',
                        'descripcio' => 'nullable|string',
                        'color' => 'required|string|max:7',
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
            Log::error('Error en updateDetails: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'No s\'ha pogut actualitzar el registre.'
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

                case 'rol':
                    $item = Rol::findOrFail($id);
                    $itemName = $item->nom;
                    break;

                case 'alerta-punt':
                    $item = AlertaPuntDeRecollida::findOrFail($id);
                    $itemName = 'Alerta #' . $item->id;

                    // Eliminar la imagen si existe
                    if ($item->imatge && file_exists(public_path($item->imatge))) {
                        unlink(public_path($item->imatge));
                    }
                    break;

                case 'tipus-alerta':
                    $item = TipusAlerta::findOrFail($id);
                    $itemName = $item->nom;
                    break;

                case 'tipus-event':
                    $item = TipusEvent::findOrFail($id);
                    $itemName = $item->nom;

                    // Verificar si hay eventos que usan este tipo
                    if ($item->events()->count() > 0) {
                        throw new \Exception('No es pot eliminar aquest tipus d\'event perquè hi ha events que l\'utilitzen.');
                    }
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
            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
                    'action' => 'Ha eliminat ' . $type . ': ' . $itemName
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Element eliminat correctament'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar ' . $type . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'No s\'ha pogut eliminar el registre.'
            ], 500);
        }
    }
    public function navigatorStats()
    {
        // Usar límites, agregación y muestreo para grandes conjuntos de datos
        $totalRecords = NavigatorInfo::count();

        // Si hay más de 10,000 registros, hacemos muestreo
        $limit = $totalRecords > 10000 ? 10000 : $totalRecords;
        $samplingPercentage = $totalRecords > 0 ? round(($limit / $totalRecords) * 100, 1) : 100;

        // Extraer datos de plataforma con límite para evitar sobrecarga
        $platformData = NavigatorInfo::select('platform')
            ->whereNotNull('platform')
            ->limit($limit)
            ->get()
            ->groupBy('platform')
            ->map(function ($items) {
                return count($items);
            });

        // Para navegadores, extraer información desde user_agent
        $browserData = NavigatorInfo::select('user_agent', 'app_name')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                $ua = strtolower($item->user_agent ?? '');
                if (strpos($ua, 'chrome') !== false && strpos($ua, 'edg/') === false)
                    return 'Chrome';
                if (strpos($ua, 'firefox') !== false)
                    return 'Firefox';
                if (strpos($ua, 'safari') !== false && strpos($ua, 'chrome') === false)
                    return 'Safari';
                if (strpos($ua, 'edg') !== false)
                    return 'Edge';
                if (strpos($ua, 'opera') !== false || strpos($ua, 'opr/') !== false)
                    return 'Opera';
                if (strpos($ua, 'trident') !== false || strpos($ua, 'msie') !== false)
                    return 'Internet Explorer';
                return 'Otro';
            })
            ->countBy();

        // Dispositivos móviles vs desktop
        $deviceData = NavigatorInfo::select('user_agent')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                $ua = strtolower($item->user_agent ?? '');
                if (
                    strpos($ua, 'mobile') !== false ||
                    strpos($ua, 'android') !== false ||
                    strpos($ua, 'iphone') !== false ||
                    strpos($ua, 'ipad') !== false
                ) {
                    return 'Mobile';
                }
                return 'Desktop';
            })
            ->countBy();

        // Resoluciones de pantalla más comunes
        $resolutionData = NavigatorInfo::selectRaw('CONCAT(screen_width, "x", screen_height) as resolution')
            ->whereNotNull('screen_width')
            ->whereNotNull('screen_height')
            ->limit($limit)
            ->get()
            ->countBy('resolution')
            ->sortDesc()
            ->take(10);

        // Idiomas
        $languageData = NavigatorInfo::select('language')
            ->whereNotNull('language')
            ->limit($limit)
            ->get()
            ->countBy('language')
            ->sortDesc()
            ->take(10);

        // Soporte para cookies (estadística)
        $cookiesEnabled = NavigatorInfo::where('cookie_enabled', true)->count();
        $cookiesDisabled = NavigatorInfo::where('cookie_enabled', false)->count();

        // Promedio de núcleos de CPU (hardware_concurrency)
        $avgConcurrency = NavigatorInfo::whereNotNull('hardware_concurrency')
            ->avg('hardware_concurrency');

        // Distribuir los datos para la vista
        return view('admin.navigator-stats', compact(
            'totalRecords',
            'limit',
            'samplingPercentage',
            'platformData',
            'browserData',
            'deviceData',
            'resolutionData',
            'languageData',
            'cookiesEnabled',
            'cookiesDisabled',
            'avgConcurrency'
        ));
    }
    public function navigatorStatsData()
    {
        // Usar límites para evitar carga excesiva en el servidor
        $totalRecords = NavigatorInfo::count();
        $limit = $totalRecords > 10000 ? 10000 : $totalRecords;
        $samplingPercentage = $totalRecords > 0 ? round(($limit / $totalRecords) * 100, 1) : 100;

        // Extraer datos básicos (mismo código que en navigatorStats pero adaptado para JSON)
        $platformData = NavigatorInfo::select('platform')
            ->whereNotNull('platform')
            ->limit($limit)
            ->get()
            ->groupBy('platform')
            ->map(function ($items) {
                return count($items);
            });

        $browserData = NavigatorInfo::select('user_agent', 'app_name')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                $ua = strtolower($item->user_agent ?? '');
                if (strpos($ua, 'chrome') !== false && strpos($ua, 'edg/') === false)
                    return 'Chrome';
                if (strpos($ua, 'firefox') !== false)
                    return 'Firefox';
                if (strpos($ua, 'safari') !== false && strpos($ua, 'chrome') === false)
                    return 'Safari';
                if (strpos($ua, 'edg') !== false)
                    return 'Edge';
                if (strpos($ua, 'opera') !== false || strpos($ua, 'opr/') !== false)
                    return 'Opera';
                if (strpos($ua, 'trident') !== false || strpos($ua, 'msie') !== false)
                    return 'Internet Explorer';
                return 'Otro';
            })
            ->countBy();

        $deviceData = NavigatorInfo::select('user_agent')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                $ua = strtolower($item->user_agent ?? '');
                if (
                    strpos($ua, 'mobile') !== false ||
                    strpos($ua, 'android') !== false ||
                    strpos($ua, 'iphone') !== false ||
                    strpos($ua, 'ipad') !== false
                ) {
                    return 'Mobile';
                }
                return 'Desktop';
            })
            ->countBy();

        $resolutionData = NavigatorInfo::selectRaw('CONCAT(screen_width, "x", screen_height) as resolution')
            ->whereNotNull('screen_width')
            ->whereNotNull('screen_height')
            ->limit($limit)
            ->get()
            ->countBy('resolution')
            ->sortDesc()
            ->take(10);

        $languageData = NavigatorInfo::select('language')
            ->whereNotNull('language')
            ->limit($limit)
            ->get()
            ->countBy('language')
            ->sortDesc()
            ->take(10);

        $cookiesEnabled = NavigatorInfo::where('cookie_enabled', true)->count();
        $cookiesDisabled = NavigatorInfo::where('cookie_enabled', false)->count();

        $avgConcurrency = NavigatorInfo::whereNotNull('hardware_concurrency')
            ->avg('hardware_concurrency');

        // Preparar datos para JSON
        return response()->json([
            'totalRecords' => $totalRecords,
            'limit' => $limit,
            'samplingPercentage' => $samplingPercentage,
            'platformLabels' => $platformData->keys(),
            'platformData' => $platformData->values(),
            'browserLabels' => $browserData->keys(),
            'browserData' => $browserData->values(),
            'deviceLabels' => $deviceData->keys(),
            'deviceData' => $deviceData->toArray(),
            'resolutionData' => $resolutionData->toArray(),
            'languageLabels' => $languageData->keys(),
            'languageData' => $languageData->values(),
            'cookiesEnabled' => $cookiesEnabled,
            'cookiesDisabled' => $cookiesDisabled,
            'avgConcurrency' => $avgConcurrency,
        ]);
    }
}