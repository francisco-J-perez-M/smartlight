<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Faker\Factory as Faker;

class PosteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 15; $i++) {
            $poste = [
                'ubicacion' => $faker->streetAddress,
                'estado' => $faker->randomElement(['activo', 'inactivo', 'mantenimiento']),
            ];

            Http::post('http://localhost:3000/postes', $poste);
        }
    }
}