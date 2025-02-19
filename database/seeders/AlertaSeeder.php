<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Faker\Factory as Faker;

class AlertaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Obtener los IDs de los sensores desde la API
        $response = Http::get('http://localhost:3000/sensores');
        $sensores = $response->json();

        foreach ($sensores as $sensor) {
            $alerta = [
                'sensor' => $sensor['_id'], // Usar el ID del sensor
                'mensaje' => $faker->sentence,
                'resuelta' => $faker->boolean,
            ];

            Http::post('http://localhost:3000/alertas', $alerta);
        }
    }
}