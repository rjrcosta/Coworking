<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class EdificioPiso extends Model
{
    use HasFactory;

    protected $table = 'edificio_piso'; // Tabela pivot

    protected $fillable = [
        'cod_edificio',
        'cod_piso'
    ];

    // Relacionamento com a tabela Edificio
    public function edificio()
    {
        return $this->belongsTo(Edificio::class, 'cod_edificio');
    }

    // Relacionamento com a tabela Piso
    public function piso()
    {
        return $this->belongsTo(Piso::class, 'cod_piso');
    }

    // Relação com a tabela salaPiso
    public function salaPiso()
    {
        return $this->hasMany(SalaPiso::class, 'cod_edificio_piso', 'id');
    }
}
