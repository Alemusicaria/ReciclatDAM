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

Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);

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

Route::localizedGroup(function () {
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
});