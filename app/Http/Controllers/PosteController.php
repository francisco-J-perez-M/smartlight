<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;


class PosteController extends Controller
{
    // Obtener todos los postes
    public function index(Request $request)
{
    // Obtener todos los postes de la API
    $response = Http::get('http://localhost:3000/postes');
    $postes = $response->json();

    // Asegurar que $postes es un array
    if (!is_array($postes)) {
        $postes = [];
    }

    // Búsqueda por ID
    if ($request->has('search')) {
        $search = $request->input('search');
        $postes = array_filter($postes, function ($poste) use ($search) {
            return stripos($poste['_id'], $search) !== false;
        });
    }

    // Paginación manual con LengthAwarePaginator
    $perPage = 6;
    $page = $request->get('page', 1);
    $offset = ($page - 1) * $perPage;

    $postesPaginated = new LengthAwarePaginator(
        array_slice($postes, $offset, $perPage), // Elementos de la página actual
        count($postes), // Total de elementos
        $perPage, // Elementos por página
        $page, // Página actual
        ['path' => $request->url(), 'query' => $request->query()] // Opciones de paginación
    );

    return view('postes.index', [
        'postes' => $postesPaginated,
        'search' => $request->input('search', ''), // Pasar el término de búsqueda a la vista
    ]);
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
        // dd($poste);
        return view('postes.show', compact('poste'));
    }
    public function edit($id)
    {
    $responsePoste = Http::get("http://localhost:3000/postes/{$id}");
    $poste = $responsePoste->json();

    $responseSensores = Http::get("http://localhost:3000/sensores");
    $sensores = $responseSensores->json();

    return view('postes.form', compact('poste', 'sensores'));
    }


    // Actualizar un poste por ID
    public function update(Request $request, $id)
    {
        $data = $request->only(['ubicacion', 'estado', 'sensores']);
    
        Http::put("http://localhost:3000/postes/{$id}", $data);
    
        return redirect()->route('postes.index')->with('success', 'Poste actualizado correctamente');
    }
    

    // Eliminar un poste por ID
    public function destroy($id)
    {
        Http::delete("http://localhost:3000/postes/{$id}");
        return redirect()->route('postes.index');
    }
}
