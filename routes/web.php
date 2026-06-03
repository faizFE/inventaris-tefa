<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

// Admin & User
Route::middleware(['auth', 'role:admin,user'])->group(function () {
    Route::resource('barang', BarangController::class);
    Route::resource('peminjaman', PeminjamanController::class);
});

// Khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('peminjam', PeminjamController::class)->only(['index']);
});