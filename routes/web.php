<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\ProfileController;

// Guest Routes
Route::middleware('guest')->group(function () {
    // Halaman utama menampilkan form login, tetapi tidak dinamai 'login' agar tidak bentrok
    Route::get('/', [AuthController::class, 'showLogin'])->name('home');

    // Fallback untuk POST ke root agar tidak 405
    Route::post('/', function () {
        return redirect()->route('login');
    });

    // Tampilkan form login (GET) dan proses login (POST)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth.firebase')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/save-fcm-token', [AuthController::class, 'saveFcmToken'])->name('save.fcm.token');

    // Tugas Routes
    Route::get('/dashboard', [TugasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/selesai', [TugasController::class, 'selesai'])->name('tugas.selesai');
    Route::get('/tugas/create', [TugasController::class, 'create'])->name('tugas.create');
    Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
    Route::get('/tugas/{id}/edit', [TugasController::class, 'edit'])->name('tugas.edit');
    Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('tugas.update');
    Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');
    Route::post('/refresh-quote', [TugasController::class, 'refreshQuote'])->name('refresh.quote');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
