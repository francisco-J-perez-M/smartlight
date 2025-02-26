<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlertaController extends Controller
{
    // Obtener todos las alertas
    public function index()
    {
        $response = Http::get('http://localhost:3000/alertas');
        $alertas = $response->json();

        return view('alertas.index', compact('alertas'));
    }

    // Mostrar el formulario de creación
    public function create()
    {
        // Obtener los sensores desde la API
        $response = Http::get('http://localhost:3000/sensores');
        $sensores = $response->json();

        // Pasar los sensores a la vista
        return view('Alertas.form', compact('sensores'));
    }

    // Mostrar los detalles de una alerta específica
    public function show($id)
    {
        // Obtener la alerta específica desde la API
        $response = Http::get("http://localhost:3000/alertas/{$id}");
        $alerta = $response->json();

        // Pasar la alerta a la vista de detalles
        return view('Alertas.show', compact('alerta'));
    }

    // Mostrar el formulario de edición
    public function edit($id)
    {
        // Obtener la alerta específica desde la API
        $response = Http::get("http://localhost:3000/alertas/{$id}");
        $alerta = $response->json();

        // Obtener los sensores desde la API
        $response = Http::get('http://localhost:3000/sensores');
        $sensores = $response->json();

        // Pasar la alerta y los sensores a la vista
        return view('Alertas.form', compact('alerta', 'sensores'));
    }

    // Crear una nueva alerta
    public function store(Request $request)
    {
        Http::post("http://localhost:3000/alertas", $request->all());
        return redirect()->route('alertas.index');
    }

    // Actualizar una alerta por ID
    public function update(Request $request, $id)
    {
        Http::put("http://localhost:3000/alertas/{$id}", $request->all());
        return redirect()->route('alertas.index');
    }

    // Eliminar una alerta por ID
    public function destroy($id)
    {
        Http::delete("http://localhost:3000/alertas/{$id}");
        return redirect()->route('alertas.index');
    }
}