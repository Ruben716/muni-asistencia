<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Intern;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Services\Kafka\ProducerService;




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

public function exportIndividualReport($internId, ProducerService $producer)
{
    $intern = Intern::with('attendances')->find($internId);

    if (!$intern) {
        return response()->json(['error' => 'Intern no encontrado'], 404);
    }

    // Convertir fechas a instancias Carbon seguras
    $startDate = \Carbon\Carbon::parse($intern->start_date);
    $endDate   = \Carbon\Carbon::parse($intern->end_date);
    $today     = \Carbon\Carbon::now();

    // Generar listado de días laborables con asistencia
    $reportData = collect();
    for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
        if (!in_array($date->dayOfWeek, [6, 0])) { // Excluye sábado (6) y domingo (0)
            $attendance = $intern->attendances->firstWhere('date', $date->toDateString());

            if ($date->lt($today)) {
                if ($attendance) {
                    $checkIn  = $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : 'N/A';
                    $checkOut = $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : 'N/A';
                    $status   = 'Sí';
                } else {
                    $checkIn = $checkOut = 'N/A';
                    $status = 'No';
                }
            } else {
                $checkIn = $checkOut = $status = '';
            }

            $reportData->push([
                'date'      => $date->format('Y-m-d'),
                'check_in'  => $checkIn,
                'check_out' => $checkOut,
                'status'    => $status,
            ]);
        }
    }

    // ✅ Estructura final del payload para Kafka
    $payload = [
        'id_plantilla' => 4,
        'datos' => [
            'intern' => [
                'name'       => $intern->name,
                'lastname'   => $intern->lastname,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date'   => $endDate->format('Y-m-d'),
            ],
            'reportData' => $reportData->toArray(),
        ]
    ];

    // Enviar por Kafka
    $reporte = $producer->enviarSolicitudIndividual($internId, $payload);

    return response()->json([
        'mensaje'    => 'Solicitud enviada correctamente',
        'reporte_id' => $reporte->id,
        'estado'     => $reporte->estado,
    ]);
}


}