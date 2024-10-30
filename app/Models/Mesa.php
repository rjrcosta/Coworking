<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{

    /** @use HasFactory<\Database\Factories\MesaFactory> */
    use HasFactory;
    protected $fillable = [

        'status',
        'qrcode',
        'cod_sala_piso',
    ];
    public $timestamps = true;

    public function salaPiso()
    {
        return $this->belongsTo(SalaPiso::class, 'cod_sala_piso');
    }

    // Relacionamento direto com a sala
    public function sala()
    {
        return $this->hasOneThrough(
            Sala::class,          // Modelo final que queremos acessar
            SalaPiso::class,      // Modelo intermediário
            'id',                 // Chave primária em SalaPiso (ex: id)
            'id',                 // Chave primária em Sala (ex: id)
            'cod_sala_piso',      // Chave estrangeira em Mesa (deve ser a chave que liga Mesa a SalaPiso)
            'cod_sala'            // Chave estrangeira em SalaPiso que conecta a Sala
        );
    }
}
