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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cod_mesa')->references('id')->on('mesas')->onDelete('cascade');
            $table->date('date');                  // Data da reserva
            $table->time('horario_inicio');        // Hora de início
            $table->time('horario_fim');           // Hora de fim
            $table->enum('status', ['reserved', 'checked-in', 'cancelled']); // Status
            $table->timestamp('check_in_time')->nullable();  // Hora do check-in
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
