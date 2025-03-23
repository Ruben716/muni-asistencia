<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Intern;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Muestra la lista de asistencias.
     */
    public function index()
    {
        $attendances = Attendance::with('intern')->orderBy('date', 'desc')->get();
        return view('admin.attendances.index', compact('attendances'));
    }

    /**
     * Muestra el formulario de asistencia (si lo necesitas).
     */
    public function create()
    {
        return view('attendances.create');
    }

    /**
     * Registra la asistencia.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|numeric|digits:8',
            'type' => 'required|in:check_in,check_out', // 'check_in' para entrada, 'check_out' para salida
        ]);

        $intern = Intern::where('dni', $request->dni)->first();

        if (!$intern) {
            return back()->withErrors(['dni' => 'DNI no encontrado']);
        }

        $today = Carbon::now()->toDateString();
        $now = Carbon::now()->toTimeString();

        $attendance = Attendance::where('intern_id', $intern->id)->where('date', $today)->first();

        if ($request->type === 'check_in') {
            if ($attendance) {
                return back()->withErrors(['dni' => 'Ya registraste tu ingreso hoy']);
            }

            Attendance::create([
                'intern_id' => $intern->id,
                'date' => $today,
                'check_in' => $now,
            ]);

            return back()->with('success', 'Ingreso registrado correctamente');
        }

        if ($request->type === 'check_out') {
            if (!$attendance) {
                return back()->withErrors(['dni' => 'No puedes registrar salida sin haber ingresado']);
            }

            if ($attendance->check_out) {
                return back()->withErrors(['dni' => 'Ya registraste tu salida hoy']);
            }

            $attendance->update([
                'check_out' => $now,
            ]);

            return back()->with('success', 'Salida registrada correctamente');
        }
    }
}
