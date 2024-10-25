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
        Schema::create('edificio_piso', function (Blueprint $table) {
            $table->id();
            // Chave estrangeira para a tabela pisos
            $table->foreignId('cod_piso')->constrained('pisos')->onDelete('cascade');
            // Chave estrangeira para a tabela edificios
            $table->foreignId('cod_edificio')->constrained('edificios')->onDelete('cascade');
            $table->timestamps(); // Isso adiciona as colunas created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edificio_piso');
    }
};
