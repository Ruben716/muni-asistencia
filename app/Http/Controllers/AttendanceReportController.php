<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Intern;
use App\Models\Attendance;



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
            
        // Obtener fechas hábiles
        $startDate = $intern->start_date;
        $endDate = $intern->end_date;
        $allDates = collect();
        
        for ($date = $startDate; $date <= $endDate; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
            if (!in_array(date('N', strtotime($date)), [6, 7])) { // Excluir sábados (6) y domingos (7)
                $allDates->push($date);
            }
        }

        // Construir reporte
        // Construir reporte
        $reportData = $allDates->map(function ($date) use ($intern) {
        $attendance = $intern->attendances->where('date', $date)->first();

        return [
                'date' => $date,
                'status' => $attendance
                    ? ($attendance->is_late ? 'Tarde' : 'Presente')
                    : 'Ausente',
                'check_in' => $attendance?->check_in ?? 'N/A',
                'check_out' => $attendance?->check_out ?? 'N/A',
    ];
});


        $pdf = Pdf::loadView('admin.attendances.individual_report', compact('intern', 'reportData'));

        return $pdf->stream('reporte_individual_asistencias.pdf');
    } 


}
