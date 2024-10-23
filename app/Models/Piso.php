<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piso extends Model
{
    /** @use HasFactory<\Database\Factories\PisoFactory> */
    use HasFactory;

    protected $fillable=[
        'numero',
    ];

    // Definir a relação muitos para muitos com Edificio
    public function edificios()
    {
        return $this->belongsToMany(Edificio::class, 'edificio_piso', 'cod_piso', 'cod_edificio');
    }
}
