<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\CacheController;
use App\Http\Controllers\CacheLockController;
use App\Http\Controllers\CodiController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\PasswordResetTokenController;
use App\Http\Controllers\PremiController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;




Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::resource('caches', CacheController::class);
Route::resource('cache-locks', CacheLockController::class);
Route::resource('codis', CodiController::class);
Route::resource('migrations', MigrationController::class);
Route::resource('password-reset-tokens', PasswordResetTokenController::class);
Route::resource('premis', PremiController::class);
Route::resource('sessions', SessionController::class);
Route::resource('users', UserController::class);

Route::post('/set-locale', function (Illuminate\Http\Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, config('app.available_locales'))) {
        Session::put('locale', $locale);
    }
    return response()->json(['status' => 'success']);
});

Route::get('set-locale/{locale}', function ($locale) {
    if (in_array($locale, config('app.available_locales'))) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});