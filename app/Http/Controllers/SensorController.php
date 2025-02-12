<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class sensorController extends Controller
{
    // Obtener todos los sensores
    public function index()
    {
        $response = Http::get('http://localhost:3000/sensores');
        $sensores = $response->json();

        return view('sensores.index', compact('sensores'));
    }

    // Obtener un sensor por ID
    public function show($id)
    {
        $response = Http::get("{http://localhost:3000/sensores");
        return $response->json();
    }

    // Crear un sensor poste
    public function store(Request $request)
    {
        $response = Http::post("http://localhost:3000/sensores", $request->all());
        return $response->json();
    }

    // Actualizar un sensor por ID
    public function update(Request $request, $id)
    {
        $response = Http::put("http://localhost:3000/sensores", $request->all());
        return $response->json();
    }

    // Eliminar un sensor por ID
    public function destroy($id)
    {
        $response = Http::delete("http://localhost:3000/sensores");
        return $response->json();
    }
}
