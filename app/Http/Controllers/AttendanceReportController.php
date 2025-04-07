<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Intern;
use App\Models\Attendance;
use Carbon\Carbon;



class AttendanceReportController extends Controller
{
public function exportGlobalReport()
{
    // Obtener todos los practicantes
    $interns = Intern::with(['attendances'])->get();

    // Estructurar los datos
    $reportData = $interns->map(function ($intern) {
        $totalAsistencias = $intern->attendances->count();
        $tardanzas = $intern->attendances->where('is_late', true)->count();
        $asistenciasATiempo = $totalAsistencias - $tardanzas;

        return [
            'name' => $intern->name . ' ' . $intern->lastname,
            'dni' => $intern->dni,
            'tardanzas' => $tardanzas,
            'asistencias' => $asistenciasATiempo,
            'total' => $totalAsistencias
        ];
    });

    // Cargar la vista para el PDF
    $pdf = Pdf::loadView('admin.attendances.global_report', compact('reportData'));

    return $pdf->stream('reporte_global_asistencias.pdf');
}

public function exportIndividualReport($internId)
{
    $intern = Intern::find($internId);
    if (!$intern) {
        // Manejo de error si el practicante no existe
        return response()->json(['error' => 'Intern not found'], 404);
    }

    // Asegurarnos de que las fechas son objetos Carbon
    $startDate = Carbon::parse($intern->start_date);
    $endDate = Carbon::parse($intern->end_date);
    $today = Carbon::now();  // Obtener la fecha actual
    
    // Filtrar solo días hábiles
    $allDates = collect();
    for ($date = $startDate; $date <= $endDate; $date->addDay()) {
        if (!in_array($date->dayOfWeek, [6, 0])) { // Excluir sábados y domingos
            $allDates->push($date->format('Y-m-d'));
        }
    }

    // Mapear los datos de asistencia
    $reportData = $allDates->map(function ($date) use ($intern, $today) {
        $attendance = $intern->attendances()->where('date', $date)->first();

        // Si la fecha es anterior a hoy
        if (Carbon::parse($date)->lt($today)) {
            if ($attendance) {
                $checkInTime = Carbon::parse($attendance->check_in);
                $checkOutTime = Carbon::parse($attendance->check_out);
                $expectedTime = Carbon::parse($intern->expected_start_time);
                
                // Comparar si la hora de entrada es después de la hora esperada
                if ($checkInTime->gt($expectedTime)) {
                    $status = 'Tarde';
                } else {
                    $status = 'Presente';
                }
                $checkInTime = $checkInTime->format('H:i');  // Solo mostrar la hora
                $checkOutTime = $checkOutTime->format('H:i'); // Solo mostrar la hora
            } else {
                $status = 'Ausente';
                $checkInTime = 'N/A'; // No hubo registro de hora de entrada
                $checkOutTime = 'N/A'; // No hubo registro de hora de salida
            }
        } else {
            // Si la fecha es en el futuro, dejar en blanco
            $status = '';
            $checkInTime = '';
            $checkOutTime = '';
        }

        return [
            'date' => $date,
            'status' => $status,
            'check_in' => $checkInTime ?? 'N/A',
            'check_out' => $checkOutTime ?? 'N/A',
        ];
    });

    // Generar el PDF con los datos
    $pdf = Pdf::loadView('admin.attendances.individual_report', compact('intern', 'reportData'));

    return $pdf->stream('reporte_individual_asistencias.pdf');
}


}