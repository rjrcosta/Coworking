<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
