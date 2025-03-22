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
        Schema::create('interns', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->string('lastname');
            $table->string('dni', 8)->unique();
            $table->string('phone', 9)->nullable();
            $table->time('arrival_time'); // Hora de entrada establecida
            $table->time('departure_time'); // Hora de salida establecida
            $table->date('start_date'); // Inicio de prácticas
            $table->date('end_date'); // Fin de prácticas
            $table->string('institution')->nullable(); // Institución de procedencia
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
