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
        Schema::create('mesas', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('livre'); // Status da mesa
            $table->string('qrcode')->unique()->nullable()->default(null); // QR code único e nullable
            $table->foreignId('cod_sala_piso')->constrained('sala_piso')->onDelete('restrict'); // Associação com salaPiso
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mesas');
    }
};
