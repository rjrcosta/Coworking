<?php

namespace Database\Factories;

/**
* Editado por Thiago França
* 18/10/2024
*/

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Edificio>
 */
class EdificioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             //Factory com os campos do Edifício
             'nome' => fake()->name(),
             'morada' =>  fake()->address(),
             'cidade' =>  fake()->city(),
             'cod_postal' => fake()->postcode(),
             'contacto' => fake()->numerify("### ### ###"),
             'created_at' => now(),
             'updated_at' => now(),
        ];
    }
}
