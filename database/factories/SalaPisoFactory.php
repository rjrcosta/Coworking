<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sala;
use App\Models\EdificioPiso;
use App\Models\SalaPiso;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalaPiso>
 */
class SalaPisoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
     protected $model = \App\Models\SalaPiso::class;

    public function definition(): array
    {
       do {
            // Seleciona IDs aleatórios para Sala e EdificioPiso
            $cod_sala = Sala::inRandomOrder()->first()->id;
            $cod_edificio_piso = EdificioPiso::inRandomOrder()->first()->id;

            // Verifica se a combinação já existe
            $exists = SalaPiso::where('cod_sala', $cod_sala)
                              ->where('cod_edificio_piso', $cod_edificio_piso)
                              ->exists();

        } while ($exists); // Repete até encontrar uma combinação única

        return [
            'cod_sala' => $cod_sala,
            'cod_edificio_piso' => $cod_edificio_piso,
        ];
    }
}
