<?php

namespace App\Services\Kafka;

use App\Models\ReporteAsistencia;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Log;

class ProducerService
{
    public function enviarSolicitudIndividual(int $internId, array $payload): ReporteAsistencia
    {
        
        $reporte = ReporteAsistencia::create([
            'intern_id' => $internId,
            'tipo'      => 'individual',
            'estado'    => 'pendiente',
        ]);

        $correlationId = Uuid::uuid4()->toString();

        
        $idPlantilla = $payload['id_plantilla'] ?? null;
        $datos       = $payload['datos'] ?? [];
        $intern      = $datos['intern'] ?? [];

        
        if (!$idPlantilla || empty($intern)) {
            Log::error('❌ Payload inválido en ProducerService', compact('payload'));
            throw new \Exception('Payload inválido: falta id_plantilla o intern');
        }

        
        $body = [
            'id_plantilla' => $idPlantilla,
            'datos_json' => $datos, 
        ];

        $mensaje = new Message(
            key: $correlationId,
            headers: [
                'correlation_id' => $correlationId,
                'tipo_reporte'   => 'individual',
            ],
            body: $body
        );

        Kafka::publish()
            ->onTopic('report.requests')
            ->withMessage($mensaje)
            ->send();

        $reporte->update([
            'correlation_id' => $correlationId,
            'estado'         => 'en_proceso',
        ]);

        return $reporte;
    }
}
