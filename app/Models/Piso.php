<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piso extends Model
{
    /** @use HasFactory<\Database\Factories\PisoFactory> */
    use HasFactory;

    protected $fillable = [
        'andar',
    ];

    // Relacionamento muitos-para-muitos com Edificio através de `edificio_piso`
    public function edificios()
    {
        return $this->belongsToMany(Edificio::class, 'edificio_piso', 'cod_piso', 'cod_edificio')
                    ->withTimestamps(); // Mantém o timestamp das relações
    }

    // Relacionamento com a tabela `EdificioPiso`, que representa a associação
    public function edificioPisos()
    {
        return $this->hasMany(EdificioPiso::class, 'cod_piso');
    }
}
