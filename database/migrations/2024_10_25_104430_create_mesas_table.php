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
            $table->string('qrcode')->unique(); // QR code único para check-in
            $table->foreignId('cod_sala_piso')->constrained('sala_piso')->onDelete('cascade'); // Associação com sala
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mesas');
    }
};
