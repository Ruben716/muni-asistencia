<?php

use App\Http\Controllers\InternController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\AttendanceController;

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
Route::get('/interns/{intern}', [InternController::class, 'show'])->name('interns.show');







require __DIR__.'/auth.php';
