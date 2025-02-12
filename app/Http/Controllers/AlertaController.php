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
    
        // Obtener una alertas por ID
        public function show($id)
        {
            $response = Http::get("{http://localhost:3000/alertas");
            return $response->json();
        }
    
        // Crear una nueva alerta
        public function store(Request $request)
        {
            $response = Http::post("http://localhost:3000/alertas", $request->all());
            return $response->json();
        }
    
        // Actualizar una alerta por ID
        public function update(Request $request, $id)
        {
            $response = Http::put("http://localhost:3000/alertas", $request->all());
            return $response->json();
        }
    
        // Eliminar una alerta por ID
        public function destroy($id)
        {
            $response = Http::delete("http://localhost:3000/alertas");
            return $response->json();
        }
}
