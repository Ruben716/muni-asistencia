<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Intern;
use Carbon\Carbon;

class AttendanceForm extends Component
{
   // AttendanceForm.php (Componente Livewire)

public $dni = '';
public $attendances;

public function mount()
{
    $this->loadAttendances();
}

public function loadAttendances()
{
    $this->attendances = Attendance::with('intern')
        ->whereDate('date', Carbon::today())
        ->orderBy('created_at', 'desc')
        ->get();
}

public function registerAttendance()
{
    // Validación para asegurarse de que el DNI existe en la base de datos
    $this->validate([
        'dni' => 'required|digits:8|exists:interns,dni',
    ], [
        'dni.exists' => 'DNI no encontrado en el sistema.'
    ]);

    $intern = Intern::where('dni', $this->dni)->first();  // Buscar al practicante por su DNI
    $today = Carbon::today()->toDateString();  // Obtener la fecha actual
    $now = Carbon::now();  // Obtener la hora actual

    // Buscar si ya existe un registro de asistencia para el practicante en el día de hoy
    $attendance = Attendance::where('intern_id', $intern->id)
                            ->where('date', $today)
                            ->first();

    if (!$attendance) {
        // Si no hay un registro, registrar la entrada (check-in)
        Attendance::create([
            'intern_id' => $intern->id,
            'date' => $today,
            'check_in' => $now->toTimeString(),
        ]);
        session()->flash('success', 'Entrada registrada correctamente para ' . $intern->name);
    } elseif (!$attendance->check_out) {
        // Si hay un registro pero no hay salida (check-out), registrar la salida
        $attendance->update([
            'check_out' => $now->toTimeString(),
        ]);
        session()->flash('success', 'Salida registrada correctamente para ' . $intern->name);
    } else {
        session()->flash('error', 'Ya registraste entrada y salida hoy.');
    }

    $this->dni = ''; // Limpiar el campo de entrada del DNI
    $this->loadAttendances(); // Recargar las asistencias para reflejar el cambio
}

}