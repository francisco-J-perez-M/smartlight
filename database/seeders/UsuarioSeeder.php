<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Faker\Factory as Faker;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 15; $i++) {
            $usuario = [
                'nombre' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'), // Contraseña por defecto
                'rol' => $faker->randomElement(['admin', 'tecnico']),
            ];

            Http::post('http://localhost:3000/usuarios', $usuario);
        }
    }
}