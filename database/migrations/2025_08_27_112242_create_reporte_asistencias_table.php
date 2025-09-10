<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reporte_asistencias', function (Blueprint $table) {
        $table->id();
        $table->foreignId('intern_id')->constrained()->onDelete('cascade');
        $table->string('tipo');
        $table->string('estado')->default('pendiente');
        $table->string('correlation_id')->nullable();
        $table->string('resultado_url')->nullable();
        $table->text('detalle_error')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_asistencias');
    }
};
