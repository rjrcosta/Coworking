<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    /** @use HasFactory<\Database\Factories\ReservaFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',          // ID do usuário que fez a reserva
        'mesas_id',          // ID da mesa reservada
        'horario_inicio',   // Horário de início da reserva
        'horario_fim',      // Horário de fim da reserva
        'status',           // Status da reserva (reservado, checked-in, cancelado)
        'check_in_time',    // Hora do check-in (se aplicável)
    ];
}
