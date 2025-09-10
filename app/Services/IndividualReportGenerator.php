<?php

namespace App\Services;

use App\Models\Intern;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class IndividualReportGenerator
{
    public function generar(int $internId): string
    {
        $intern = Intern::with('attendances')->findOrFail($internId);
        $startDate = Carbon::parse($intern->start_date);
        $endDate = Carbon::parse($intern->end_date);
        $today = Carbon::now();

        $allDates = collect();
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            if (!in_array($date->dayOfWeek, [6, 0])) {
                $allDates->push($date->format('Y-m-d'));
            }
        }

        $reportData = $allDates->map(function ($date) use ($intern, $today) {
            $attendance = $intern->attendances()->where('date', $date)->first();

            if (Carbon::parse($date)->lt($today)) {
                if ($attendance) {
                    $checkIn = Carbon::parse($attendance->check_in);
                    $checkOut = Carbon::parse($attendance->check_out);
                    $expected = Carbon::parse($intern->expected_start_time);
                    $status = $checkIn->gt($expected) ? 'Tarde' : 'Presente';
                    $checkInTime = $checkIn->format('H:i');
                    $checkOutTime = $checkOut->format('H:i');
                } else {
                    $status = 'Ausente';
                    $checkInTime = 'N/A';
                    $checkOutTime = 'N/A';
                }
            } else {
                $status = '';
                $checkInTime = '';
                $checkOutTime = '';
            }

            return [
                'date' => $date,
                'status' => $status,
                'check_in' => $checkInTime,
                'check_out' => $checkOutTime,
            ];
        });

        $pdf = Pdf::loadView('admin.attendances.individual_report', compact('intern', 'reportData'));
        $filePath = 'reportes/asistencias/reporte_' . $intern->dni . '_' . now()->format('Ymd_His') . '.pdf';
        $pdf->save(storage_path('app/public/' . $filePath));

        return 'storage/' . $filePath;
    }
}
