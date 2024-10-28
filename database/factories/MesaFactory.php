<?php

namespace Database\Factories;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mesa;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mesa>
 */
class MesaFactory extends Factory
{
    protected $model = Mesa::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {
        $id= $this->faker->unique()->word;
         return [
           'status' => $this->faker->randomElement(['livre', 'reservada']),
            'qrcode' => $this->faker->unique()->uuid(), // Gerar QR code único
            'cod_sala_piso' => fake()->numberBetween(1, 5), // Defina o ID de uma sala existente para associações
        
        ];
    }
}
