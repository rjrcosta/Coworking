<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cidade>
 */
class CidadeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     
    public function definition(): array
    {
        static $index = 0;
        $cities = ['Braga', 'Porto', 'Matosinhos', 'Vila do Conde', 'Póvoa do Lanhoso', 'Viana do Castelo'];
    
        // Se o índice ultrapassar o tamanho do array, reseta para o início
        $city = $cities[$index % count($cities)];
        $index++; // Incrementa o índice para a próxima execução
    
        return [
            'nome' => $city,
        ];
    }
}
