<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contacto extends Model
{
    /** @use HasFactory<\Database\Factories\ContactoFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
        'email',
        'message',
    ];
}
