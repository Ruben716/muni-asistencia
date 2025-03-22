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
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('intern_id')->constrained()->onDelete('cascade'); 
        $table->date('date');
        $table->time('check_in');
        $table->time('check_out')->nullable();
        $table->boolean('is_late')->default(false); // Indica si el practicante llegó tarde
        $table->string('absence_reason')->nullable(); // Justificación de ausencia (opcional)
        $table->timestamps();

        // Índice para mejorar consultas
        $table->index(['intern_id', 'date']);

        // Restricción para evitar registros duplicados en un mismo día
        $table->unique(['intern_id', 'date']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
