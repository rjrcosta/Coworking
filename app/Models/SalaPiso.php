<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SalaPiso extends Model
{
    use HasFactory;

    protected $table = 'sala_piso'; // Define o nome exato da tabela

    protected $fillable = [
        'cod_edificio_piso', // Chave estrangeira da relação entre Edificio e Piso
        'cod_sala'
    ];

    // Relacionamento com a tabela Sala
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'cod_sala');
    }

    // Relacionamento com a tabela EdificioPiso (a tabela pivot entre Edificio e Piso)
    public function edificioPiso()
    {
        return $this->belongsTo(EdificioPiso::class, 'cod_edificio_piso');
    }
<<<<<<< HEAD

    // Relacionamento com a mesa
    public function mesa()
    {
        return $this->hasMany(Mesa::class, 'cod_sala_piso');
=======
    public function mesa() 
     {
        return $this->hasMany(Mesa::class,'cod_sala_piso');
>>>>>>> 617c8fb78627d635f78168f03701c433510fdfee
    }
}

