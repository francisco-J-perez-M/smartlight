<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SensorController extends Controller
{
    // Obtener todos los sensores
    public function index()
    {
        $response = Http::get('http://localhost:3000/sensores');
        $sensores = $response->json();

        return view('sensores.index', compact('sensores'));
    }

    // Mostrar el formulario para crear un nuevo sensor
    public function create()
    {
        // Obtener la lista de postes desde la API
        $response = Http::get('http://localhost:3000/postes');
        $postes = $response->json();

        return view('sensores.form', compact('postes'));
    }

    // Crear un sensor
    public function store(Request $request)
    {
        Http::post('http://localhost:3000/sensores', $request->all());
        return view('sensores.form');
    }

    // Obtener un sensor por ID
    public function show($id)
    {
        $response = Http::get("http://localhost:3000/sensores/{$id}");
        return $response->json();
    }

    // Actualizar un sensor por ID
    public function update(Request $request, $id)
    {
        $response = Http::put("http://localhost:3000/sensores/{$id}", $request->all());
        return $response->json();
    }

    // Eliminar un sensor por ID
    public function destroy($id)
    {
        $response = Http::delete("http://localhost:3000/sensores/{$id}");
        return $response->json();
    }
}