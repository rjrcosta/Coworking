<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    /** @use HasFactory<\Database\Factories\CidadeFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
    ];

    public function edificios() {
        return $this->hasMany(Edificio::class);
    }
}
