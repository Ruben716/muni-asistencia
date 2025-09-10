<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Kafka\ConsumerHandler;
use Junges\Kafka\Facades\Kafka;

class KafkaConsumeRespuestas extends Command
{
    protected $signature = 'kafka:consume-respuestas';
    protected $description = 'Consume mensajes del tópico report.results y actualiza reportes';

    public function handle()
    {
        $this->info("👂 Escuchando tópico: report.results");

        $consumer = Kafka::createConsumer()
            ->subscribe('report.results')
            ->withHandler(function ($message) {
                app(ConsumerHandler::class)->handle($message);
            })
            ->withConsumerGroupId('asistencias-group') // 
            ->build();

        $consumer->consume();

        return self::SUCCESS;
    }
}
