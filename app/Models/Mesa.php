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

    public function edificio()
    {
        return $this->hasOneThrough(Edificio::class,  
              // Modelo final que queremos acessar   
                    EdificioPiso::class,   // Modelo intermediário     
                       'id', // Chave primária em EdificioPiso 
                       'id', // Chave primária em Edificio 
                       'cod_sala_piso', // Chave primária em Mesa 
                       'cod_edificio' // Chave estrangeira em EdificioPiso que conecta a Edificio
                        );
 
    }

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
