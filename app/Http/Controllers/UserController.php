<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    // Obtener todos los usuarios
    public function index(Request $request)
    {
        $response = Http::get('http://localhost:3000/usuarios');
        $usuarios = $response->json();

        // Paginación manual
        $perPage = 6;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $usuariosPaginated = array_slice($usuarios, $offset, $perPage);
        $totalPages = ceil(count($usuarios) / $perPage);

        return view('usuarios.index', [
            'usuarios' => $usuariosPaginated,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('usuarios.form');
    }

    // Obtener un usuario por ID
    public function show($id)
    {
        // Realizar la solicitud HTTP para obtener los datos del usuario
        $response = Http::get("http://localhost:3000/usuarios/{$id}");

        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // Obtener los datos del usuario desde la respuesta JSON
            $usuario = $response->json();

            // Pasar los datos del usuario a la vista
            return view('usuarios.show', compact('usuario'));
        } else {
            // Manejar el caso en que la solicitud no fue exitosa
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado');
        }
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        Http::post("http://localhost:3000/usuarios", $request->all());

        return redirect()->route('usuarios.index');
    }

    // Actualizar un usuario por ID
    public function update(Request $request, $id)
    {
        // Realizar la solicitud HTTP para actualizar el usuario
        $response = Http::put("http://localhost:3000/usuarios/{$id}", $request->all());

        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // Redirigir a la lista de usuarios con un mensaje de éxito
            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
        } else {
            // Redirigir a la lista de usuarios con un mensaje de error
            return redirect()->route('usuarios.index')->with('error', 'Error al actualizar el usuario');
        }
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $response = Http::get("http://localhost:3000/usuarios/{$id}");

        if ($response->successful()) {
            $usuario = $response->json();
            return view('usuarios.form', compact('usuario'));
        } else {
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado');
        }
    }

    // Eliminar un usuario por ID
    public function destroy($id)
    {
        // Eliminar el usuario
        Http::delete("http://localhost:3000/usuarios/{$id}");

        // Redirigir a la lista de usuarios
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
