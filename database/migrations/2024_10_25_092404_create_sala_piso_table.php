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
        Schema::create('sala_piso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cod_edificio_piso')->constrained('edificio_piso')->onDelete('cascade'); // Relacionamento com a tabela pivot `edificio_piso`
            $table->foreignId('cod_sala')->constrained('salas')->onDelete('cascade'); // Relacionamento com a tabela `salas`
            // Define uma restrição única na combinação de cod_sala e cod_edificio_piso
            $table->unique(['cod_sala', 'cod_edificio_piso']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sala_piso');
    }
};
