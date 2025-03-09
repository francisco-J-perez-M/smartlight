<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GraficasController extends Controller
{
    // Función para gráficas de usuarios
    public function usuarios()
{
    // Obtener los datos de la API
    $response = Http::get('http://localhost:3000/usuarios');
    $usuarios = $response->json();

    // Procesar datos para las gráficas de usuarios
    $roles = collect($usuarios)->groupBy('rol')->map->count();

    // Procesar datos para la gráfica de dominios de correo
    $dominios = collect($usuarios)->map(function ($usuario) {
        // Extraer el dominio del correo electrónico
        $email = $usuario['email'];
        return substr(strrchr($email, "@"), 1); // Obtener todo después del "@"
    })->groupBy(function ($dominio) {
        return $dominio; // Agrupar por dominio
    })->map->count(); // Contar usuarios por dominio

    return view('graficas.usuarios', [
        'roles' => $roles,
        'dominios' => $dominios,
    ]);
}

    // Función para gráficas de alertas
    public function alertas()
    {
        // Obtener los datos de la API
        $response = Http::get('http://localhost:3000/alertas');
        $alertas = $response->json();

        // Procesar datos para las gráficas de alertas
        $estados = collect($alertas)->groupBy('resuelta')->map->count();
        $estados = [
            'Resueltas' => $estados->get(true, 0), // Alertas resueltas
            'Pendientes' => $estados->get(false, 0), // Alertas pendientes
        ];

        // Procesar datos para la segunda gráfica: Alertas por mes
        $alertasPorMes = collect($alertas)->groupBy(function ($alerta) {
            return \Carbon\Carbon::parse($alerta['fecha'])->format('Y-m'); // Agrupar por mes
        })->map->count();

        return view('graficas.alertas', [
            'estados' => $estados,
            'alertasPorMes' => $alertasPorMes,
        ]);
    }

    // Función para gráficas de postes
    public function postes()
    {
        // Obtener los datos de la API
        $response = Http::get('http://localhost:3000/postes');
        $postes = $response->json();

        // Procesar datos para las gráficas de postes
        $estados = collect($postes)->groupBy('estado')->map->count();

        // Procesar datos para la segunda gráfica: Postes por ubicación
        $ubicaciones = collect($postes)->groupBy('ubicacion')->map->count();

        return view('graficas.postes', [
            'estados' => $estados,
            'ubicaciones' => $ubicaciones,
        ]);
    }

    // Función para gráficas de sensores
    public function sensores()
    {
        // Obtener los datos de la API
        $response = Http::get('http://localhost:3000/sensores');
        $sensores = $response->json();

        // Procesar datos para las gráficas de sensores
        $estados = collect($sensores)->groupBy('estado')->map->count();

        // Procesar datos para la segunda gráfica: Sensores por poste
        $sensoresPorPoste = collect($sensores)->groupBy(function ($sensor) {
            return $sensor['poste'] ? $sensor['poste']['ubicacion'] : 'Sin Poste';
        })->map->count();

        return view('graficas.sensores', [
            'estados' => $estados,
            'sensoresPorPoste' => $sensoresPorPoste,
        ]);
    }
}