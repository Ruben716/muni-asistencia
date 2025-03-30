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
     * Gestiona la vista por día, semana o mes, y paginado.
     */
    public function index(Request $request)
    {
        // Establecer la fecha actual
        $today = Carbon::today();

        // Filtrar por el tipo de periodo (día, semana o mes)
        $filter = $request->input('filter', 'today'); // 'today', 'week', 'month'
        
        if ($filter == 'week') {
            // Obtener el inicio de la semana (lunes) y fin de la semana (domingo)
            $startOfWeek = $today->startOfWeek();
            $endOfWeek = $today->endOfWeek();

            $attendances = Attendance::with('intern')
                ->whereBetween('date', [$startOfWeek, $endOfWeek])
                ->orderBy('date', 'desc')
                ->paginate(10); // Paginación de 10 registros por página
        } elseif ($filter == 'month') {
            // Obtener el inicio y fin del mes
            $startOfMonth = $today->startOfMonth();
            $endOfMonth = $today->endOfMonth();

            $attendances = Attendance::with('intern')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->orderBy('date', 'desc')
                ->paginate(10); // Paginación de 10 registros por página
        } else {
            // Default: Asistencias del día actual
            $attendances = Attendance::with('intern')
                ->whereDate('date', $today)
                ->orderBy('created_at', 'desc')
                ->paginate(10); // Paginación de 10 registros por página
        }
        
        // Pasar las asistencias a la vista
        return view('admin.attendances.index', compact('attendances', 'filter'));
    }

    /**
     * Muestra el formulario de asistencia (si lo necesitas).
     */
    public function create()
    {
        return view('attendances.create');
    }

    /**
     * Registra la asistencia (entrada o salida).
     */
    public function store(Request $request)
    {
        // Validación del DNI
        $request->validate([
            'dni' => 'required|numeric|digits:8|exists:interns,dni', // Validar que el DNI esté registrado
        ], [
            'dni.exists' => 'DNI no encontrado en el sistema.'
        ]);

        // Buscar al practicante por su DNI
        $intern = Intern::where('dni', $request->dni)->first();
        $today = Carbon::today()->toDateString(); // Fecha actual
        $now = Carbon::now()->toTimeString(); // Hora actual

        $intern = Intern::where('dni', $request->dni)->first(); // Busca al practicante por su DNI

        if ($intern) {
         session(['dni_registrado' => $intern->id]); // Guarda el ID en vez del DNI
        }



        // Buscar si ya existe un registro de asistencia para el practicante hoy
        $attendance = Attendance::where('intern_id', $intern->id)
                                ->where('date', $today)
                                ->first();

        if (!$attendance) {
            // Si no existe un registro de entrada para hoy, registrar la entrada (check_in)
            Attendance::create([
                'intern_id' => $intern->id,
                'date' => $today,
                'check_in' => $now,
            ]);
            return back()->with('success', 'Entrada registrada correctamente');
        } elseif (!$attendance->check_out) {
            // Si ya existe un registro pero no se ha registrado la salida (check_out), registrar la salida
            $attendance->update([
                'check_out' => $now,
            ]);
            return back()->with('success', 'Salida registrada correctamente');
        } else {
            // Si ya se registró entrada y salida, mostrar un error
            return back()->withErrors(['dni' => 'Ya registraste entrada y salida hoy.']);
        }
    }
    //ultima añadidura pero en prueva 
    
}
