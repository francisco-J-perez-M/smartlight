<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class AlertaController extends Controller
{
    // Obtener todas las alertas
    public function index(Request $request)
{
    // Obtener todas las alertas de la API
    $response = Http::get('http://localhost:3000/alertas');
    $alertas = $response->json();

    // Búsqueda por ID
    if ($request->has('search')) {
        $search = $request->input('search');
        $alertas = array_filter($alertas, function ($alerta) use ($search) {
            return stripos($alerta['_id'], $search) !== false;
        });
    }

    // Paginación manual con LengthAwarePaginator
    $perPage = 6;
    $page = $request->get('page', 1);
    $offset = ($page - 1) * $perPage;

    $alertasPaginated = new LengthAwarePaginator(
        array_slice($alertas, $offset, $perPage), // Elementos de la página actual
        count($alertas), // Total de elementos
        $perPage, // Elementos por página
        $page, // Página actual
        ['path' => $request->url(), 'query' => $request->query()] // Opciones de paginación
    );

    return view('alertas.index', [
        'alertas' => $alertasPaginated,
        'search' => $request->input('search', ''), // Pasar el término de búsqueda a la vista
    ]);
}
    // Método para buscar alertas por ID
public function search(Request $request)
{
    // Obtener todas las alertas de la API
    $response = Http::get('http://localhost:3000/alertas');
    $alertas = $response->json();

    // Filtrar alertas según el término de búsqueda
    $search = $request->input('search');
    $filteredAlertas = collect($alertas)->filter(function ($alerta) use ($search) {
        return stripos($alerta['_id'], $search) !== false;
    });

    // Devolver los resultados filtrados en formato JSON
    return response()->json($filteredAlertas->values());
}

    // Mostrar el formulario de creación
    public function create()
    {
        // Obtener los sensores desde la API
        $response = Http::get('http://localhost:3000/sensores');
        $sensores = $response->json();

        // Pasar los sensores a la vista
        return view('alertas.form', compact('sensores'));
    }

    // Mostrar los detalles de una alerta específica
    public function show($id)
    {
        // Obtener la alerta específica desde la API
        $response = Http::get("http://localhost:3000/alertas/{$id}");
        $alerta = $response->json();

        // Pasar la alerta a la vista de detalles
        return view('alertas.show', compact('alerta'));
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
        return view('alertas.form', compact('alerta', 'sensores'));
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