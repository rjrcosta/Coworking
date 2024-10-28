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
        'cod_sala_piso'
    ];
    public $timestamps = true;
}
