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

    // Rutas para el panel de administración
    Route::prefix('admin')->middleware(['auth'])->group(function () {
        // Aplicar validación de administrador a todo el grupo
        Route::group([
            'middleware' => function ($request, $next) {
                if (auth()->user()->rol_id != 1) {
                    return redirect()->route('home')->with('error', 'No tens permís per accedir al panell d\'administració');
                }
                return $next($request);
            }
        ], function () {
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
        });

    });
});