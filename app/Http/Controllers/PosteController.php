<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PosteController extends Controller
{

    // Obtener todos los postes
    public function index()
    {
        $response = Http::get('http://localhost:3000/postes');
        return $response->json();
    }

    // Obtener un poste por ID
    public function show($id)
    {
        $response = Http::get("{http://localhost:3000/postes");
        return $response->json();
    }

    // Crear un nuevo poste
    public function store(Request $request)
    {
        $response = Http::post("http://localhost:3000/postes", $request->all());
        return $response->json();
    }

    // Actualizar un poste por ID
    public function update(Request $request, $id)
    {
        $response = Http::put("http://localhost:3000/postes", $request->all());
        return $response->json();
    }

    // Eliminar un poste por ID
    public function destroy($id)
    {
        $response = Http::delete("http://localhost:3000/postes");
        return $response->json();
    }
}