<?php

use App\Http\Controllers\PersekotRequestController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// Redirect root URL based on auth and role
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('persekot.index');
    }
});

// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/persekot', [PersekotRequestController::class, 'index'])->name('persekot.index');
    Route::get('/persekot/create', [PersekotRequestController::class, 'create'])->name('persekot.create');
    Route::post('/persekot', [PersekotRequestController::class, 'store'])->name('persekot.store');
    Route::get('/persekot/{persekotRequest}', [PersekotRequestController::class, 'show'])->name('persekot.show');
    Route::get('/persekot/{persekotRequest}/pdf', [PersekotRequestController::class, 'exportPdf'])->name('persekot.exportPdf');
});

// Admin routes
Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/persekot/{persekotRequest}/approve', [AdminController::class, 'approve'])->name('admin.persekot.approve');
    Route::post('/persekot/{persekotRequest}/reject', [AdminController::class, 'reject'])->name('admin.persekot.reject');
    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
});
