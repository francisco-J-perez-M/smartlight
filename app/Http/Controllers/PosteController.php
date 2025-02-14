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
        $postes = $response->json();

        // Asegurar que $postes es un array
        if (!is_array($postes)) {
            $postes = [];
        }

        return view('postes.index', compact('postes'));
    }

    public function create()
    {
        // Obtener la lista de sensores desde la API
        $response = Http::get('http://localhost:3000/sensores');
        $sensores = $response->json();

        if (!is_array($sensores)) {
            $sensores = [];
        }

        return view('Postes.form', compact('sensores'));
    }

    // Crear un nuevo poste
    public function store(Request $request)
    {
        Http::post("http://localhost:3000/postes", $request->all());
        return redirect()->route('postes.index');
    }   

    // Obtener un poste por ID
    public function show($id)
    {
        $response = Http::get("http://localhost:3000/postes/{$id}");
        $poste = $response->json();

        if (!is_array($poste)) {
            $poste = [];
        }

        return view('postes.show', compact('poste'));
    }

    // Actualizar un poste por ID
    public function update(Request $request, $id)
    {
        Http::put("http://localhost:3000/postes/{$id}", $request->all());
        return redirect()->route('postes.index');
    }

    // Eliminar un poste por ID
    public function destroy($id)
    {
        Http::delete("http://localhost:3000/postes/{$id}");
        return redirect()->route('postes.index');
    }
}
