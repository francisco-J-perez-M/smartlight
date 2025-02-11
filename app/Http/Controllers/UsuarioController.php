<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsuarioController extends Controller
{
    // Obtener todos los usuarios
    public function index()
    {
        $response = Http::get('http://localhost:3000/usuarios');
        return $response->json();
    }

    // Obtener un usuario por ID
    public function show($id)
    {
        $response = Http::get("{http://localhost:3000/usuarios");
        return $response->json();
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        $response = Http::post("http://localhost:3000/usuarios", $request->all());
        return $response->json();
    }

    // Actualizar un usuario por ID
    public function update(Request $request, $id)
    {
        $response = Http::put("http://localhost:3000/usuarios", $request->all());
        return $response->json();
    }

    // Eliminar un usuario por ID
    public function destroy($id)
    {
        $response = Http::delete("http://localhost:3000/usuarios");
        return $response->json();
    }
}
