<?php

namespace Database\Factories;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mesa;
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
           
            'status' => $this->faker->randomElement(['disponível', 'reservada']),
            'qrcode' => 'public/qrcodes'.$this->faker->uuid(), // Você pode gerar um QR Code aqui se necessário
            
        ];
    }
}
