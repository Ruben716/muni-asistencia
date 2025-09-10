<?php

namespace App\Services\Kafka;

use App\Models\ReporteAsistencia;
use Illuminate\Support\Facades\Log;

class ConsumerHandler
{
    public function handle($message): void
    {
        $body = $message->getBody();
        $idReporte = $body['id_reporte'] ?? null;
        $estado = $body['estado'] ?? 'error';

        if (!$idReporte) {
            Log::warning("⚠️ Mensaje recibido sin id_reporte: " . json_encode($body));
            return;
        }

        $reporte = ReporteAsistencia::find($idReporte);

        if (!$reporte) {
            Log::warning("⚠️ Reporte con ID $idReporte no encontrado.");
            return;
        }

        if ($estado === 'finalizado') {
            $ruta = $body['ruta_minio'] ?? null;

            $reporte->update([
                'estado' => 'listo',
                'resultado_url' => $ruta,
            ]);

            Log::info("✅ Reporte #$idReporte actualizado como listo. Ruta: $ruta");
        } else {
            $error = $body['error'] ?? 'Error desconocido';

            $reporte->update([
                'estado' => 'error',
                'detalle_error' => $error,
            ]);

            Log::error("❌ Reporte #$idReporte falló. Error: $error");
        }
    }
}
