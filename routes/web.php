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

Route::resource('interns', InternController::class)->middleware('auth');;


Route::resource('attendances', AttendanceController::class)->middleware('auth');

//nueva ruta alternativa para mas detalles de la vista 
Route::get('/interns/{intern}', [InternController::class, 'show'])->name('interns.show')->middleware('auth');

//control de pdf 
Route::get('/attendance/export', [AttendanceHistoryController::class, 'export'])->name('attendance.export');





// Define la ruta para el historial de asistencias

Route::get('/historial-asistencias', [AttendanceHistoryController::class, 'index'])->name('historial-asistencias.index'); // Cambio aquí

// Rutas de reportes tanto el gloval y el individual 
// Ruta para el reporte global
Route::get('/export-global-report', [AttendanceReportController::class, 'exportGlobalReport'])->name('export.global');

// Ruta para el reporte individual (requiere el ID del practicante)
Route::get('/export-individual-report/{intern}', [AttendanceReportController::class, 'exportIndividualReport'])->name('export.individual');






require __DIR__.'/auth.php';
