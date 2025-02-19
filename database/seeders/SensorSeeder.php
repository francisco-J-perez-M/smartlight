<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Faker\Factory as Faker;

class SensorSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Obtener los IDs de los postes desde la API
        $response = Http::get('http://localhost:3000/postes');
        $postes = $response->json();

        foreach ($postes as $poste) {
            $sensor = [
                'poste' => $poste['_id'], // Usar el ID del poste
                'estado' => $faker->randomElement(['funcionando', 'fallado']),
                'ultimaRevision' => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
            ];

            Http::post('http://localhost:3000/sensores', $sensor);
        }
    }
}