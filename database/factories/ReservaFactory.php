<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mesa;
use App\Models\Reserva;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         // Busca um usuário existente aleatoriamente
         $user = User::inRandomOrder()->first();
        
         // Busca uma mesa existente aleatoriamente
         $mesa = Mesa::inRandomOrder()->first();
 
         // Gera horários aleatórios entre 9h e 16h
         $horarioInicio = Carbon::now()->addDays(rand(0, 7))->setHour(rand(9, 16)); 
         $horarioFim = (clone $horarioInicio)->addHours(rand(1, 3)); // Duração de 1 a 3 horas
 
         return [
             'user_id' => $user ? $user->id : null, // Se existir, pega o id do usuário
             'cod_mesa' => $mesa ? $mesa->id : null, // Se existir, pega o id da mesa
             'horario_inicio' => $horarioInicio,
             'horario_fim' => $horarioFim,
             'status' => 'Reservado',
             'date' => $horarioInicio->toDateString(), // Define a data com base no horario_inicio
             'created_at' => now(),
             'updated_at' => now(),
         ];
    }
}
