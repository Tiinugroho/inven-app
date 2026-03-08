<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

// Jika user mengakses URL utama "/", langsung alihkan ke dashboard.
// Middleware auth akan menahan mereka ke halaman login jika belum masuk.
Route::redirect('/', '/dashboard');

// Kelompokkan semua route yang butuh login di sini
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Gunakan Controller yang baru saja kita buat
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // RoleController route POS, Inventori, dll bisa ditambahkan di bawah sini
    // Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    
});

require __DIR__.'/settings.php';