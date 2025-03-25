<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Intern;
use Carbon\Carbon;

class AttendanceForm extends Component
{
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

    public function updatedDni()
    {
        if (strlen($this->dni) == 8) {
            $this->registerAttendance();
        }
    }

    public function registerAttendance()
    {
        $this->validate([
            'dni' => 'required|digits:8|exists:interns,dni',
        ], [
            'dni.exists' => 'DNI no encontrado en el sistema.'
        ]);

        $intern = Intern::where('dni', $this->dni)->first();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        $attendance = Attendance::where('intern_id', $intern->id)
                                ->where('date', $today)
                                ->first();

        if (!$attendance) {
            // Registrar entrada
            Attendance::create([
                'intern_id' => $intern->id,
                'date' => $today,
                'check_in' => $now->toTimeString(),
            ]);
            session()->flash('success', 'Entrada registrada correctamente para ' . $intern->name);
        } elseif (!$attendance->check_out) {
            // Registrar salida
            $attendance->update([
                'check_out' => $now->toTimeString(),
            ]);
            session()->flash('success', 'Salida registrada correctamente para ' . $intern->name);
        } else {
            session()->flash('error', 'Ya registraste entrada y salida hoy.');
        }

        $this->dni = ''; // Limpiar input
        $this->loadAttendances(); // Recargar asistencias
    }

    public function render()
    {
        return view('livewire.attendance-form', [
            'attendances' => $this->attendances
        ]);
    }
}