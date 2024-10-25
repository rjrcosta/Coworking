<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sala>
 */
class SalaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //Factory com os campos da sala
            'nome' => fake()->name(),
            'lotacao' =>  fake()->numberBetween(1, 20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
