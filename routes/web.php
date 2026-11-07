<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;

// ─── Halaman Utama → Redirect ke login siswa ───────────────────
Route::get('/', function () {
    return redirect()->route('siswa.loginPage');
});

// ─── SISWA ROUTES ───────────────────────────────────────────────
Route::get('/siswa/login', [SiswaController::class, 'loginPage'])->name('siswa.loginPage');
Route::post('/siswa/login', [SiswaController::class, 'login'])->name('siswa.login');
Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
Route::post('/siswa/assessment', [SiswaController::class, 'submitAssessment'])->name('siswa.assessment');
Route::post('/siswa/reset', [SiswaController::class, 'resetAssessment'])->name('siswa.reset');
Route::get('/siswa/logout', [SiswaController::class, 'logout'])->name('siswa.logout');

// ─── GURU BK ROUTES ─────────────────────────────────────────────
Route::get('/guru/login', [GuruController::class, 'loginPage'])->name('guru.loginPage');
Route::post('/guru/login', [GuruController::class, 'login'])->name('guru.login');
Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('dashboard.guru');
Route::get('/guru/logout', [GuruController::class, 'logout'])->name('guru.logout');