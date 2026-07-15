<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});



Route::middleware(['auth'])->group(function () {

    // Redirect halaman utama setelah login, sesuai role
    Route::get('/dashboard', function () {
        return auth()->user()->isAdminOrPetugas()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('laporan.index');
    })->name('dashboard');

    // Modul Pelaporan (mahasiswa)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');

    // Modul Admin (kelola laporan)
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::put('/laporan/{laporan}/update-status', [AdminDashboardController::class, 'updateStatus'])->name('updateStatus');
    });
});


require __DIR__.'/auth.php';
