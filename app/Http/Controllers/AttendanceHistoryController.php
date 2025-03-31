<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class AttendanceHistoryController extends Controller
{
    /**
     * Muestra el historial completo de asistencias.
     * Puedes filtrar por día, semana, mes o todos.
     */
    public function index(Request $request)
    {
        // Obtener la opción de filtro (por defecto es por día)
        $filter = $request->get('filter', 'day'); // 'day', 'week', 'month'

        switch ($filter) {
            case 'week':
                $attendances = $this->getAttendanceByWeek();
                break;
            case 'month':
                $attendances = $this->getAttendanceByMonth();
                break;
            case 'day':
            default:
                $attendances = $this->getAttendanceByDay();
                break;
        }

        return view('admin.attendances.history', compact('attendances', 'filter'));
    }

    /**
     * Obtiene las asistencias agrupadas por día.
     */
    private function getAttendanceByDay()
    {
        return Attendance::with('intern')
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function($attendance) {
                return Carbon::parse($attendance->date)->format('Y-m-d'); // Agrupar por fecha
            });
    }

    /**
     * Obtiene las asistencias agrupadas por semana.
     */
    private function getAttendanceByWeek()
    {
        return Attendance::with('intern')
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function($attendance) {
                return Carbon::parse($attendance->date)->format('o-\WW'); // Formato para la semana del año
            });
    }

    /**
     * Obtiene las asistencias agrupadas por mes.
     */
    private function getAttendanceByMonth()
    {
        return Attendance::with('intern')
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function($attendance) {
                return Carbon::parse($attendance->date)->format('Y-m'); // Agrupar por año-mes
            });
    }
    public function export(Request $request)
    {
    // Obtener el filtro
    $filter = $request->get('filter', 'day');

    // Obtener asistencias según el filtro
    switch ($filter) {
        case 'week':
            $attendances = $this->getAttendanceByWeek();
            $title = "Reporte Semanal de Asistencias";
            break;
        case 'month':
            $attendances = $this->getAttendanceByMonth();
            $title = "Reporte Mensual de Asistencias";
            break;
        case 'day':
        default:
            $attendances = $this->getAttendanceByDay();
            $title = "Reporte Diario de Asistencias";
            break;
    }

    // Generar PDF con la vista 'attendances.report'
    $pdf = Pdf::loadView('admin.attendances.report', compact('attendances', 'title', 'filter'));

    // Descargar el archivo
    return $pdf->download('reporte_asistencias.pdf');
    }

}
