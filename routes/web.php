<?php

use App\Http\Controllers\InternController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceHistoryController;
use App\Http\Controllers\AttendanceReportController;







Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Rutas solo para el ADMIN
Route::middleware(['auth' ])->group(function () {
    Route::resource('interns', InternController::class);
    Route::get('/interns/{intern}', [InternController::class, 'show'])->name('interns.show');

    // Rutas de reportes
    Route::get('/export-global-report', [AttendanceReportController::class, 'exportGlobalReport'])->name('export.global');
    Route::get('/export-individual-report/{intern}', [AttendanceReportController::class, 'exportIndividualReport'])->name('export.individual');
});

// Rutas accesibles tanto para ADMIN como para USER
Route::middleware(['auth'])->group(function () {
    Route::resource('attendances', AttendanceController::class)
    ->names([
        'index' => 'attendances.index',  // Asigna el nombre 'attendances.index' a la ruta index
        'create' => 'attendances.create',
        'store' => 'attendances.store',
        'show' => 'attendances.show',
        'edit' => 'attendances.edit',
        'update' => 'attendances.update',
        'destroy' => 'attendances.destroy',
    ]);

    Route::get('/attendance/export', [AttendanceHistoryController::class, 'export'])->name('attendance.export');
    Route::get('/historial-asistencias', [AttendanceHistoryController::class, 'index'])->name('historial-asistencias.index');
});

require __DIR__.'/auth.php';        
