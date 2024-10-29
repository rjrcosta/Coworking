<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Edificio extends Model
{
    /** @use HasFactory<\Database\Factories\EdificioFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
        'morada',
        'cod_cidade',
        'cod_postal',
        'contacto',
    ];


    // Relacionamento com a tabela Cidade
    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade', 'id');
    }

    // Relacionamento muitos-para-muitos com Piso através de `edificio_piso`
    public function pisos()
    {
        return $this->belongsToMany(Piso::class, 'edificio_piso', 'cod_edificio', 'cod_piso')
            ->withTimestamps(); // Mantém o timestamp das relações
    }

    // Relacionamento com a tabela `EdificioPiso`, que representa a associação
    public function edificioPisos()
    {
        return $this->hasMany(EdificioPiso::class, 'cod_edificio');
    }

    // Relacionamento com a tabela SalaPiso para buscar salas
    public function salaPiso()
    {
        return $this->hasManyThrough(SalaPiso::class, EdificioPiso::class, 'cod_edificio', 'cod_edificio_piso', 'id', 'id');
    }

    // Método para calcular disponibilidade de salas
    public function calcularDisponibilidade($data, $periodo)
    {
        // Obter todas as mesas através das relações
        $mesas = $this->edificioPiso()
            ->with('salaPiso.mesas') // Carregar mesas a partir de salaPiso
            ->get()
            ->flatMap(function ($edificioPiso) {
                return $edificioPiso->salaPiso->flatMap(function ($salaPiso) {
                    return $salaPiso->mesas; // Retornar todas as mesas
                });
            });

        // Log para verificar as mesas carregadas
        Log::info('Mesas associadas ao edifício', ['mesas' => $mesas]);

        // Calcular a lotação total
        $lotacaoTotal = $mesas->sum(function ($mesa) {
            return $mesa->sala ? $mesa->sala->lotacao : 0; // Acessar lotacao da sala
        });

        // Log para verificar lotação total
        Log::info('Lotação total calculada', ['lotacao_total' => $lotacaoTotal]);
        
        // Contar reservas para o período selecionado
        $reservasCount = Reserva::whereIn('cod_mesa', $mesas->pluck('id'))
            ->whereDate('horario_inicio', $data)
            ->when($periodo === 'ambos', function ($query) {
                $query->whereIn('periodo', ['manha', 'tarde']);
            })
            ->count();

        return $lotacaoTotal - $reservasCount; // Disponibilidade
    }
}
