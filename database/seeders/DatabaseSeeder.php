<?php

namespace Database\Seeders;

/**
 * Editado por Thiago França
 * 18/10/2024
 */

use App\Models\Cidade;
use App\Models\Edificio;
use App\Models\EdificioPiso;
use App\Models\Piso;
use App\Models\Sala;
use App\Models\Reserva;
use App\Models\User;
use App\Models\SalaPiso;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // SEEDING ORDER
        // 1) user, cidade, 
        // 2) edificio, piso 
        // 3) edificio_piso, sala
        // 4) sala_piso

        // ****************************** Lógica para criar usuarios e cidades ************************
        // User::factory(5)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'password'=>'teste12345',
        //     'email' => 'test@example.com',
        //     'role'=>'admin'
        // ]);


        // Cidade::factory(5)->create();


        // ************************ Lógica para criar edifícios e pisos ************************

        // $faker = Faker::create();

        // //Definir os dados que irão compor o nome do edifício
        // $tipos = ['Edifício', 'Torre', 'Empreendimento'];
        // $posicao = ['Norte', 'Sul', 'Leste', 'Oeste'];



        // // Criar 50 edifícios
        // for ($i = 0; $i < 50; $i++) {
        //     //Factory com os campos do Edifício
        //     DB::table('edificios')->insert([
        //     'nome' => $faker->randomElement($tipos) . ' ' . $faker->name() . ' ' . $faker->randomElement($posicao),
        //     'morada' =>  fake()->address(),
        //     'cod_cidade' =>  fake()->numberBetween(1, 5),
        //     'cod_postal' => fake()->postcode(),
        //     'contacto' => fake()->numerify("### ### ###"),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        //     ]);
        // }

        // Piso::factory(5)->create();

        // ************************ Lógica para criar edifício_piso **************************


        // //Recupera todos os edifícios ou um conjunto específico
        // $edificios = Edificio::all(); // Ou use where(), etc., para buscar o que precisa
        // // Para cada edifício, associar pisos aleatórios
        // foreach ($edificios as $edificio) {
        //     // Recupera de 1 a 3 pisos aleatórios
        //     $pisos = Piso::inRandomOrder()->take(rand(1, 3))->pluck('id');

        //     // Associa os pisos ao edifício usando attach()
        //     $edificio->pisos()->attach($pisos);
        // }

        // ************************ Lógica para criar sala ************************

        // $faker = Faker::create();

        // // // Definir os dados que irão compor o nome da sala
        // $tipos = ['Escritório', 'Sala'];
        // $posicao = ['Centro', 'Esquerda', 'Direita', 'Trás', 'Frente', 'Esquerda-frente', 'Direita-frente', 'Esquerda-trás', 'Direita-trás', 'Centro-frente', 'Centro-trás'];
        
        // // Criar 50 salas
        // for ($i = 0; $i < 50; $i++) {
        //     //Factory com os campos da sala
        //     DB::table('salas')->insert([
        //     'nome' => $faker->randomElement($tipos) . ' ' . $faker->name() . ' ' . $faker->randomElement($posicao),
        //     'lotacao' =>  fake()->numberBetween(1, 20),
        //     ]);
        // }

        // ************************ Lógica para criar sala_piso ************************
        
        //SalaPiso::factory()->count(50)->create();
        
        
        
        // ************************ Lógica para unir sala e sala_piso ************************
        

        // //Recupera todas as salas ou um conjunto específico
        // $salas = Sala::all(); // Ou use where(), etc., para buscar o que precisa
        // // Para cada sala, associar sala_pisos aleatórios
        // foreach ($salas as $sala) {
        //     // Recupera de 1 a 3 pisos aleatórios
        //     $pisos = Piso::inRandomOrder()->take(rand(1, 3))->pluck('id');

        //     // Associa os pisos ao sala usando attach()
        //     $sala->salaPiso()->attach($pisos);
        // }




        // //*******************criaçao de mesas************************ */

        //Mesa::factory(5)->create();

        // //*************************criaçao de reservas ficticias*************** */
        // Reserva::factory(20)->create();

    }
}
