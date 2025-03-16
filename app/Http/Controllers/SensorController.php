<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class SensorController extends Controller
{
    // Obtener todos los sensores
    public function index(Request $request)
{
    // Obtener todos los sensores de la API
    $response = Http::get('http://localhost:3000/sensores');
    $sensores = $response->json();

    // Búsqueda por ID
    if ($request->has('search')) {
        $search = $request->input('search');
        $sensores = array_filter($sensores, function ($sensor) use ($search) {
            return stripos($sensor['_id'], $search) !== false;
        });
    }

    // Paginación manual con LengthAwarePaginator
    $perPage = 6;
    $page = $request->get('page', 1);
    $offset = ($page - 1) * $perPage;

    $sensoresPaginated = new LengthAwarePaginator(
        array_slice($sensores, $offset, $perPage), // Elementos de la página actual
        count($sensores), // Total de elementos
        $perPage, // Elementos por página
        $page, // Página actual
        ['path' => $request->url(), 'query' => $request->query()] // Opciones de paginación
    );

    return view('sensores.index', [
        'sensores' => $sensoresPaginated,
        'search' => $request->input('search', ''), // Pasar el término de búsqueda a la vista
    ]);
}


    // Mostrar el formulario para crear un nuevo sensor
    public function create()
    {
        // Obtener la lista de postes desde la API
        $response = Http::get('http://localhost:3000/postes');
        $postes = $response->json();

        return view('sensores.form', compact('postes'));
    }

    public function store(Request $request)
{
    Http::post('http://localhost:3000/sensores', $request->all());
    return redirect()->route('sensores.index')->with('success', 'Sensor creado correctamente.');
}



    // Obtener un sensor por ID
    public function show($id)
    {
    $response = Http::get("http://localhost:3000/sensores/{$id}");
    $sensor = $response->json();
    return view('sensores.show', compact('sensor'));
    }
    public function edit($id)
    {
    // Obtener los datos del sensor
    $response = Http::get("http://localhost:3000/sensores/{$id}");
    $sensor = $response->json();

    // Obtener la lista de postes
    $responsePostes = Http::get('http://localhost:3000/postes');
    $postes = $responsePostes->json();

    return view('sensores.form', compact('sensor', 'postes'));

    }

    // Actualizar un sensor por ID
    public function update(Request $request, $id)
    {
    $response = Http::put("http://localhost:3000/sensores/{$id}", [
        'estado' => $request->input('estado'),
        'poste' => $request->input('poste'),
    ]);

    return redirect()->route('sensores.index')->with('success', 'Sensor actualizado correctamente.');
    }

    // Eliminar un sensor por ID
    public function destroy($id)
    {
        $response = Http::delete("http://localhost:3000/sensores/{$id}");
    
        if ($response->successful()) {
            return redirect()->route('sensores.index')->with('success', 'Sensor eliminado correctamente.');
        } else {
            return redirect()->route('sensores.index')->with('error', 'Hubo un problema al eliminar el sensor.');
        }
    }
    
}