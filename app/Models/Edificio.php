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
   

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade', 'id');
    }

    // Definir a relação muitos para muitos com Piso
    public function pisos()
    {
        return $this->belongsToMany(Piso::class, 'edificio_piso', 'cod_edificio', 'cod_piso');
    }

}
