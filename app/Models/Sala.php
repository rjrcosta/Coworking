<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'lotacao',
    ];

    // Relacionamento com a tabela SalaPiso
    public function salaPiso()
    {
        return $this->hasMany(SalaPiso::class, 'cod_sala');
    }

    // Relacionamento através de SalaPiso para acessar EdificioPiso
    public function edificioPisos()
    {
        return $this->hasManyThrough(
            EdificioPiso::class,     // O modelo final que queremos alcançar
            SalaPiso::class,         // O modelo intermediário
            'cod_sala',              // Chave estrangeira no modelo intermediário (SalaPiso)
            'id',                    // Chave primária no modelo EdificioPiso
            'id',                    // Chave primária no modelo Sala
            'cod_edificio_piso'      // Chave estrangeira no modelo SalaPiso para EdificioPiso
        );
    }

    // Relacionamento com a tabela Edificio e respectiva Cidade
    public function edificio()
    {
        return $this->belongsTo(Edificio::class, 'edificio_id');
    }
    // Sala.php
    // public function cidadeNome()
    // {
    //     return $this->hasOneThrough(
    //         Cidade::class,              // O modelo final que queremos acessar
    //         EdificioPiso::class,        // O modelo intermediário
    //         'id',                        // Chave primária em EdificioPiso
    //         'id',                        // Chave primária em Cidade
    //         'id',                        // Chave primária em Sala
    //         'cod_edificio'              // Chave estrangeira em SalaPiso que conecta a Edificio
    //     )->join('edificios', 'edificios.id', '=', 'edificio_piso.cod_edificio')
    //         ->select('cidades.nome');
    // }

    // Sala.php
    // Sala.php
    public function cidadeNome()
    {
        return $this->hasOneThrough(
            Cidade::class,               // O modelo final que queremos acessar
            EdificioPiso::class,         // O modelo intermediário
            'cod_edificio',              // Chave estrangeira em EdificioPiso
            'id',                        // Chave primária em Cidade
            'id',                        // Chave primária em Sala
            'cod_piso'                   // Chave estrangeira em SalaPiso que conecta a EdificioPiso
        )->join('edificios', 'edificios.id', '=', 'edificio_piso.cod_edificio')
            ->select('cidades.nome');
    }
}
