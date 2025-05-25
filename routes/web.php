<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\CacheController;
use App\Http\Controllers\CacheLockController;
use App\Http\Controllers\CodiController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\PasswordResetTokenController;
use App\Http\Controllers\PremiController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NavigatorInfoController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ProducteController;
use App\Http\Controllers\OpinionsController;
use App\Http\Controllers\PuntDeRecollidaController;
use App\Http\Controllers\TipusAlertaController;
use App\Http\Controllers\AlertaPuntDeRecollidaController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\TipusEventController;
use App\Http\Controllers\PremiReclamatController;
use Illuminate\Http\Request;
use App\Models\PuntDeRecollida;
use App\Models\TipusAlerta;

Route::localizedGroup(function () {
    Route::get('set-password', [SocialiteController::class, 'showSetPasswordForm'])->name('set-password');
    Route::post('set-password', [SocialiteController::class, 'setPassword']);

    Route::get('login/{provider}', [SocialiteController::class, 'redirectToProvider']);
    Route::get('login/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);


    Route::post('/save-navigator-info', [NavigatorInfoController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/clear-session', function () {
        session()->forget('social_user');
        session()->forget('social_login');
        return response()->json(['status' => 'success']);
    })->name('clear-session');

    Route::post('/users/{user}/photo', [UserController::class, 'updatePhoto'])->name('users.update.photo');


    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // En routes/web.php o habilitar en routes/auth.php
    Route::get('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.update');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::resource('caches', CacheController::class);
    Route::resource('cache-locks', CacheLockController::class);
    Route::resource('codis', CodiController::class);
    Route::resource('migrations', MigrationController::class);
    Route::resource('password-reset-tokens', PasswordResetTokenController::class);
    Route::resource('premis', PremiController::class);
    Route::resource('sessions', SessionController::class);
    Route::resource('users', UserController::class);
    Route::resource('productes', ProducteController::class);

    Route::apiResource('productes', ProducteController::class);

    Route::get('/premis/search', [PremiController::class, 'search'])->name('premis.search');

    Route::resource('opinions', OpinionsController::class);
    Route::get('opinions/search', [OpinionsController::class, 'search'])->name('opinions.search');

    Route::resource('punts_de_recollida', PuntDeRecollidaController::class);
    Route::resource('tipus_alertes', TipusAlertaController::class);
    Route::resource('alertes_punts_de_recollida', AlertaPuntDeRecollidaController::class);

    // Rutas para eventos con calendario
    Route::get('/events', [EventsController::class, 'index'])->name('events');
    Route::get('/events/data', [EventsController::class, 'getEvents'])->name('events.getEvents');
    Route::get('/events/search', [EventsController::class, 'search'])->name('events.search');
    Route::get('/events/{id}', [EventsController::class, 'show'])->name('events.show');
    Route::post('/events/{id}/register', [EventsController::class, 'register'])->name('events.register')->middleware('auth');

    // Ruta para tipos de eventos
    Route::get('/tipus-events/search', [TipusEventController::class, 'search'])->name('tipus-events.search');
    Route::get('/events/{id}/check-registration', [EventsController::class, 'checkRegistration'])->name('events.checkRegistration')->middleware('auth');

    Route::resource('premis_reclamats', PremiReclamatController::class);
    Route::get('users/{user}/premis-reclamats', [PremiReclamatController::class, 'userClaims'])->name('users.premis_reclamats');

    Route::post('/premis/{id}/canjear', [App\Http\Controllers\PremiController::class, 'canjear'])
        ->name('premis.canjear')
        ->middleware('auth');

    Route::get('/offline', function () {
        return view('offline');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/scanner', function () {
            return view('scanner');
        })->name('scanner');

        // Actualiza esta línea para añadir el nombre de la ruta
        Route::post('/process-code', [App\Http\Controllers\CodiController::class, 'processCode'])->name('process-code');
    });

    Route::get('/punts-recollida/nearby', function (Request $request) {
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $distance = $request->get('distance', 1); // 1 km por defecto

        // Fórmula aproximada para buscar puntos dentro de un radio
        try {
            $points = PuntDeRecollida::where('disponible', true)
                ->whereRaw("
                    (6371 * acos(
                        cos(radians(?)) * 
                        cos(radians(latitud)) * 
                        cos(radians(longitud) - radians(?)) + 
                        sin(radians(?)) * 
                        sin(radians(latitud))
                    )) < ?",
                    [$lat, $lng, $lat, $distance]
                )
                ->get();

            return response()->json($points);
        } catch (\Exception $e) {
            \Log::error('Error en punts-recollida/nearby: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });

    Route::get('/tipus-alertes', function () {
        try {
            return response()->json(TipusAlerta::all());
        } catch (\Exception $e) {
            \Log::error('Error en tipus-alertes: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });

    // Rutas para el panel de administración
    Route::prefix('admin')->middleware(['auth'])->group(function () {
        // Aquí todas tus rutas de administrador
        Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');

        // Modales dinámicos
        Route::get('/modal-content/{type}', [App\Http\Controllers\AdminController::class, 'getModalContent'])->name('admin.modal-content');

        // Formularios
        Route::get('/create-form/{type}', [App\Http\Controllers\AdminController::class, 'getCreateForm'])->name('admin.create-form');

        // Detalles y actualización
        Route::get('/detail/{type}/{id?}', [App\Http\Controllers\AdminController::class, 'getDetails'])->name('admin.details');

        Route::get('/edit-form/{type}/{id}', [App\Http\Controllers\AdminController::class, 'getEditForm'])->name('admin.edit-form');

        Route::post('/update/{type}/{id}', [App\Http\Controllers\AdminController::class, 'updateDetails'])->name('admin.update');

        // Eliminar registro
        Route::delete('/destroy/{type}/{id}', [App\Http\Controllers\AdminController::class, 'destroyDetails'])->name('admin.destroy');
        // Eventos para FullCalendar
        Route::get('/events-json', [App\Http\Controllers\AdminController::class, 'getEventsJson'])->name('admin.events-json');

        // Gestión de usuarios
        Route::resource('users', App\Http\Controllers\UserController::class);

        // Gestión de eventos
        Route::resource('events', App\Http\Controllers\EventsController::class);
        Route::put('/events/{id}/update-dates', [App\Http\Controllers\EventsController::class, 'updateDates'])->name('events.update-dates');

        // Gestión de premios
        Route::resource('premis', App\Http\Controllers\PremiController::class);

        // Gestión de premios reclamados
        Route::resource('premis-reclamats', App\Http\Controllers\PremiReclamatController::class);
        Route::post('/premis-reclamats/{id}/approve', [App\Http\Controllers\PremiReclamatController::class, 'approve'])->name('premis-reclamats.approve');
        Route::post('/premis-reclamats/{id}/reject', [App\Http\Controllers\PremiReclamatController::class, 'reject'])->name('premis-reclamats.reject');

        // Gestión de puntos de reciclaje
        Route::resource('punts-reciclatge', App\Http\Controllers\PuntDeRecollidaController::class);

        Route::post('/admin/events', [App\Http\Controllers\EventsController::class, 'store'])->name('admin.events.store');

        Route::post('/admin/codis', [App\Http\Controllers\CodiController::class, 'store'])->name('admin.codis.store');
        Route::put('/admin/codis/{codi}', [App\Http\Controllers\CodiController::class, 'update'])->name('admin.codis.update');

        Route::post('/admin/productes', [App\Http\Controllers\ProducteController::class, 'store'])->name('admin.productes.store');
        Route::put('/admin/productes/{producte}', [App\Http\Controllers\ProducteController::class, 'update'])->name('admin.productes.update');

        Route::post('/admin/punts', [App\Http\Controllers\PuntDeRecollidaController::class, 'store'])->name('admin.punts.store');
        Route::put('/admin/punts/{punt}', [App\Http\Controllers\PuntDeRecollidaController::class, 'update'])->name('admin.punts.update');

        Route::post('/admin/rols', [App\Http\Controllers\RolController::class, 'store'])->name('admin.rols.store');
        Route::put('/admin/rols/{rol}', [App\Http\Controllers\RolController::class, 'update'])->name('admin.rols.update');

        Route::post('/admin/tipus-alertes', [App\Http\Controllers\TipusAlertaController::class, 'store'])->name('admin.tipus-alertes.store');
        Route::put('/admin/tipus-alertes/{tipusAlerta}', [App\Http\Controllers\TipusAlertaController::class, 'update'])->name('admin.tipus-alertes.update');

        Route::post('/admin/alertes-punts', [App\Http\Controllers\AlertaPuntDeRecollidaController::class, 'store'])->name('admin.alertes-punts.store');
        Route::put('/admin/alertes-punts/{alertaPuntDeRecollida}', [App\Http\Controllers\AlertaPuntDeRecollidaController::class, 'update'])->name('admin.alertes-punts.update');

        Route::post('/admin/tipus-events', [App\Http\Controllers\TipusEventController::class, 'store'])->name('admin.tipus-events.store');
        Route::put('/admin/tipus-events/{tipusEvent}', [App\Http\Controllers\TipusEventController::class, 'update'])->name('admin.tipus-events.update');

        Route::get('/admin/navigator-stats', [App\Http\Controllers\AdminController::class, 'navigatorStats'])->name('admin.navigator-stats');
        Route::get('/admin/navigator-stats-data', [App\Http\Controllers\AdminController::class, 'navigatorStatsData'])->name('admin.navigator-stats-data');
        Route::post('/admin/premis-reclamats/{id}/approve', [App\Http\Controllers\PremiReclamatController::class, 'approve'])->name('admin.premis-reclamats.approve');
        Route::post('/admin/premis-reclamats/{id}/reject', [App\Http\Controllers\PremiReclamatController::class, 'reject'])->name('admin.premis-reclamats.reject');
        Route::put('/admin/premis-reclamats/{id}', [App\Http\Controllers\PremiReclamatController::class, 'update'])->name('admin.premis-reclamats.update');
        Route::get('/admin/edit-form/premi-reclamat/{id}', [App\Http\Controllers\AdminController::class, 'getEditForm'])->name('admin.edit-form.premi-reclamat');
    });
});
