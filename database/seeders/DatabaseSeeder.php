<?php

namespace Database\Seeders;

/**
* Editado por Thiago França
* 18/10/2024
*/

use App\Models\Cidade;
use App\Models\Edificio;
use App\Models\User;
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

        // User::factory(5)->create();
        // Cidade::factory(5)->create();


        // ************************ Lógica para criar edifícios (START) ************************

        // $faker = Faker::create();

        // //Definir os dados que irão compor o nome do edifício
        // $tipos = ['Edifício', 'Torre', 'Empreendimento'];
        // $posicao = ['Norte', 'Sul', 'Leste', 'Oeste'];


        // Criar 50 edifícios
        for ($i = 0; $i < 50; $i++) {
            //Factory com os campos do Edifício
            DB::table('edificios')->insert([
            'nome' => $faker->randomElement($tipos) . ' ' . $faker->name() . ' ' . $faker->randomElement($posicao),
            'morada' =>  fake()->address(),
            'cod_cidade' =>  fake()->numberBetween(1, 5),
            'cod_postal' => fake()->postcode(),
            'contacto' => fake()->numerify("### ### ###"),
            'created_at' => now(),
            'updated_at' => now(),
            ]);
        }


        // ************************ Lógica para criar edifícios (END) ************************


        // User::factory()->create([
        //     'name' => 'test',
        //     'password'=>'teste12345',
        //     'email' => 'test@example.com',
        //     'role'=>'admin'
        // ]);

    }

}
