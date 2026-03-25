<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlertaPuntDeRecollidaController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\CacheLockController;
use App\Http\Controllers\CodiController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\NavigatorInfoController;
use App\Http\Controllers\OpinionsController;
use App\Http\Controllers\PageAndApiController;
use App\Http\Controllers\PasswordResetTokenController;
use App\Http\Controllers\PremiController;
use App\Http\Controllers\PremiReclamatController;
use App\Http\Controllers\ProducteController;
use App\Http\Controllers\PuntDeRecollidaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TipusAlertaController;
use App\Http\Controllers\TipusEventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::localizedGroup(function () {
    Route::get('set-password', [SocialiteController::class, 'showSetPasswordForm'])->name('set-password');
    Route::post('set-password', [SocialiteController::class, 'setPassword']);

    Route::get('login/google', [SocialiteController::class, 'redirectToProvider'])->defaults('provider', 'google');
    Route::get('login/google/callback', [SocialiteController::class, 'handleProviderCallback'])->defaults('provider', 'google');

    Route::post('/save-navigator-info', [NavigatorInfoController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/clear-session', [PageAndApiController::class, 'clearSession'])->name('clear-session');

    Route::post('/users/{user}/photo', [UserController::class, 'updatePhoto'])->name('users.update.photo');

    Route::get('/', [PageAndApiController::class, 'dashboard'])->name('dashboard');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // En routes/web.php o habilitar en routes/auth.php
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

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

    Route::post('/premis/{id}/canjear', [PremiController::class, 'canjear'])
        ->name('premis.canjear')
        ->middleware('auth');

    Route::get('/offline', [PageAndApiController::class, 'offline'])->name('offline');

    Route::middleware(['auth'])->group(function () {
        Route::get('/scanner', [PageAndApiController::class, 'scanner'])->name('scanner');

        Route::post('/process-code', [CodiController::class, 'processCode'])->name('process-code');
    });

    Route::get('/punts-recollida/nearby', [PageAndApiController::class, 'nearbyCollectionPoints'])->name('punts-recollida.nearby');

    Route::get('/tipus-alertes', [PageAndApiController::class, 'alertTypes'])->name('tipus-alertes.list');

    // Rutas para el panel de administración
    Route::prefix('admin')->middleware(['auth'])->group(function () {
        // Aquí todas tus rutas de administrador
        Route::controller(AdminController::class)->group(function () {
            // Modales dinámicos
            Route::get('/', 'index')->name('admin.dashboard');
            Route::get('/modal-content/{type}', 'getModalContent')->name('admin.modal-content');

            // Formularios
            Route::get('/create-form/{type}', 'getCreateForm')->name('admin.create-form');

            // Detalles y actualización
            Route::get('/detail/{type}/{id?}', 'getDetails')->name('admin.details');
            Route::get('/edit-form/{type}/{id}', 'getEditForm')->name('admin.edit-form');
            Route::post('/update/{type}/{id}', 'updateDetails')->name('admin.update');

            // Eliminar registro
            Route::delete('/destroy/{type}/{id}', 'destroyDetails')->name('admin.destroy');
            // Eventos para FullCalendar
            Route::get('/events-json', 'getEventsJson')->name('admin.events-json');
            Route::get('/navigator-stats', 'navigatorStats')->name('admin.navigator-stats');
            Route::get('/navigator-stats-data', 'navigatorStatsData')->name('admin.navigator-stats-data');
            Route::get('/edit-form/premi-reclamat/{id}', 'getEditForm')->name('admin.edit-form.premi-reclamat');
        });

        // Gestión de eventos
        Route::controller(EventsController::class)->group(function () {
            Route::put('/events/{id}/update-dates', 'updateDates')->name('events.update-dates');
            Route::post('/events', 'store')->name('admin.events.store');
        });

        // Gestión de premios

        // Gestión de premios reclamados
        Route::resource('premis-reclamats', PremiReclamatController::class)->except(['update']);

        // Gestión de puntos de reciclaje
        Route::resource('punts-reciclatge', PuntDeRecollidaController::class);

        Route::controller(CodiController::class)->group(function () {
            Route::post('/codis', 'store')->name('admin.codis.store');
            Route::put('/codis/{codi}', 'update')->name('admin.codis.update');
        });

        Route::controller(ProducteController::class)->group(function () {
            Route::post('/productes', 'store')->name('admin.productes.store');
            Route::put('/productes/{producte}', 'update')->name('admin.productes.update');
        });

        Route::controller(PuntDeRecollidaController::class)->group(function () {
            Route::post('/punts', 'store')->name('admin.punts.store');
            Route::put('/punts/{punt}', 'update')->name('admin.punts.update');
        });

        Route::controller(RolController::class)->group(function () {
            Route::post('/rols', 'store')->name('admin.rols.store');
            Route::put('/rols/{rol}', 'update')->name('admin.rols.update');
        });

        Route::controller(TipusAlertaController::class)->group(function () {
            Route::post('/tipus-alertes', 'store')->name('admin.tipus-alertes.store');
            Route::put('/tipus-alertes/{tipusAlerta}', 'update')->name('admin.tipus-alertes.update');
        });

        Route::controller(AlertaPuntDeRecollidaController::class)->group(function () {
            Route::post('/alertes-punts', 'store')->name('admin.alertes-punts.store');
            Route::put('/alertes-punts/{alertaPuntDeRecollida}', 'update')->name('admin.alertes-punts.update');
        });

        Route::controller(TipusEventController::class)->group(function () {
            Route::post('/tipus-events', 'store')->name('admin.tipus-events.store');
            Route::put('/tipus-events/{tipusEvent}', 'update')->name('admin.tipus-events.update');
        });

        Route::controller(PremiReclamatController::class)->group(function () {
            Route::post('/premis-reclamats/{id}/approve', 'approve')->name('admin.premis-reclamats.approve');
            Route::post('/premis-reclamats/{id}/reject', 'reject')->name('admin.premis-reclamats.reject');
            Route::put('/premis-reclamats/{id}', 'update')->name('admin.premis-reclamats.update');
        });
    });
});
