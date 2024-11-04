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
        'cod_mesa',          // ID da mesa reservada
        'horario_inicio',   // Horário de início da reserva
        'horario_fim',      // Horário de fim da reserva
        'status',           // Status da reserva (Reservado, Feito checked-in, Cancelada)
        'check_in_time',    // Hora do check-in (se aplicável)
        'date',             // Data da reserva
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'cod_mesa');
    }

    public function edificio()
    {
        return $this->hasOneThrough(
            Edificio::class, // O modelo final que queremos acessar
            Mesa::class,     // O modelo intermediário (mesa)
            'id',            // A chave local na mesa
            'id',            // A chave local no edifício
            'cod_mesa',      // A chave de ligação da reserva para mesa
            'cod_sala_piso'  // A chave de ligação da mesa para sala_piso
        )
            ->join('sala_piso', 'mesas.cod_sala_piso', '=', 'sala_piso.id')
            ->join('edificio_piso', 'sala_piso.cod_edificio_piso', '=', 'edificio_piso.id');
    }

    // Relacionamento com a tabela Cidade
    public function cidade()
    {
        return $this->hasOneThrough(
            Cidade::class,     // O modelo final que queremos acessar (Cidade)
            Edificio::class,   // O modelo intermediário (Edificio)
            'id',              // A chave local na tabela 'edificios'
            'cod_cidade',      // A chave de ligação no modelo 'cidade'
            'cod_mesa',        // A chave de ligação da reserva para mesa
            'cod_sala_piso'    // A chave de ligação da mesa para sala_piso
        );
    }

    // Função para definir o periodo reservado baseado na hora de inicio e fim
    public function buscaPeriodoReservado()
    {
        if ($this->horario_inicio == '08:00:00' && $this->horario_fim == '12:00:00') {
            return 'Manhã';
        } elseif ($this->horario_inicio == '14:00:00' && $this->horario_fim == '18:00:00') {
            return 'Tarde';
        } elseif ($this->horario_inicio == '08:00:00' && $this->horario_fim == '18:00:00') {
            return 'Dia todo';
        } else {
            return "Período indefinido - " . $this->horario_inicio . " - " . $this->horario_fim;
        }
    }
}
