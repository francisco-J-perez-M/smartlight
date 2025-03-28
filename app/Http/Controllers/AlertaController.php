<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AlertaController extends Controller
{
    private $apiUrl = 'http://localhost:3000/alertas';
    private $sensoresUrl = 'http://localhost:3000/sensores';
    private $postesUrl = 'http://localhost:3000/postes';
    
    // Obtener todas las alertas
    public function index(Request $request)
    {
        try {
            $response = Http::get($this->apiUrl);
            
            if (!$response->successful()) {
                throw new \Exception("Error al obtener alertas de la API");
            }
            
            $alertas = $response->json();
            
            // Filtrar alertas para técnicos (solo mostrar no resueltas)
            if (session('rol') === 'tecnico') {
                $alertas = array_filter($alertas, function ($alerta) {
                    return !$alerta['resuelta'];
                });
            }

            // Búsqueda por ID, mensaje o estado
            if ($request->has('search')) {
                $search = strtolower($request->input('search'));
                $alertas = array_filter($alertas, function ($alerta) use ($search) {
                    return stripos($alerta['_id'], $search) !== false ||
                           stripos(strtolower($alerta['mensaje']), $search) !== false ||
                           stripos($alerta['resuelta'] ? 'resuelta' : 'pendiente', $search) !== false;
                });
            }

            // Paginación manual con LengthAwarePaginator
            $perPage = 6;
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;

            $alertasPaginated = new LengthAwarePaginator(
                array_slice($alertas, $offset, $perPage),
                count($alertas),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('alertas.index', [
                'alertas' => $alertasPaginated,
                'search' => $request->input('search', ''),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en AlertaController@index: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar las alertas. Por favor, intente nuevamente.');
        }
    }

    // Método para buscar alertas
    public function search(Request $request)
    {
        try {
            $response = Http::get($this->apiUrl);
            
            if (!$response->successful()) {
                return response()->json(['error' => 'Error al obtener alertas'], 500);
            }
            
            $alertas = $response->json();
            $search = strtolower($request->input('search'));

            $filteredAlertas = collect($alertas)->filter(function ($alerta) use ($search) {
                return stripos($alerta['_id'], $search) !== false ||
                       stripos(strtolower($alerta['mensaje']), $search) !== false ||
                       stripos($alerta['resuelta'] ? 'resuelta' : 'pendiente', $search) !== false;
            });

            return response()->json($filteredAlertas->values());
            
        } catch (\Exception $e) {
            Log::error('Error en AlertaController@search: ' . $e->getMessage());
            return response()->json(['error' => 'Error en el servidor'], 500);
        }
    }

    // Mostrar el formulario de creación
    public function create()
    {
        try {
            $response = Http::get($this->sensoresUrl);
            
            if (!$response->successful()) {
                throw new \Exception("Error al obtener sensores");
            }
            
            $sensores = $response->json();
            return view('alertas.form', compact('sensores'));
            
        } catch (\Exception $e) {
            Log::error('Error en AlertaController@create: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de creación');
        }
    }

    // Mostrar los detalles de una alerta específica
    public function show($id)
    {
        try {
            $responseAlerta = Http::get("{$this->apiUrl}/{$id}");
            
            if (!$responseAlerta->successful()) {
                throw new \Exception("Alerta no encontrada");
            }
            
            $alerta = $responseAlerta->json();
            $sensor = null;
            $poste = null;

            if (!empty($alerta) && isset($alerta['sensor']['_id'])) {
                $sensorId = $alerta['sensor']['_id'];
                $responseSensor = Http::get("{$this->sensoresUrl}/{$sensorId}");
                
                if ($responseSensor->successful()) {
                    $sensor = $responseSensor->json();

                    // Obtener el poste relacionado si existe
                    if (isset($sensor['poste']['_id'])) {
                        $posteId = $sensor['poste']['_id'];
                        $responsePoste = Http::get("{$this->postesUrl}/{$posteId}");
                        
                        if ($responsePoste->successful()) {
                            $poste = $responsePoste->json();
                        }
                    }
                }
            }

            return view('alertas.show', compact('alerta', 'sensor', 'poste'));
            
        } catch (\Exception $e) {
            Log::error('Error en AlertaController@show: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar los detalles de la alerta');
        }
    }

    // Mostrar el formulario de edición
    public function edit($id)
    {
        try {
            $responseAlerta = Http::get("{$this->apiUrl}/{$id}");
            
            if (!$responseAlerta->successful()) {
                throw new \Exception("Alerta no encontrada");
            }
            
            $alerta = $responseAlerta->json();
            
            $responseSensores = Http::get($this->sensoresUrl);
            
            if (!$responseSensores->successful()) {
                throw new \Exception("Error al obtener sensores");
            }
            
            $sensores = $responseSensores->json();

            return view('alertas.form', compact('alerta', 'sensores'));
            
        } catch (\Exception $e) {
            Log::error('Error en AlertaController@edit: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de edición');
        }
    }

    // Crear una nueva alerta
    public function store(Request $request)
    {
        try {
            $response = Http::post($this->apiUrl, $request->all());
            
            if (!$response->successful()) {
                throw new \Exception("Error al crear alerta");
            }
            
            return redirect()->route('alertas.index')->with('success', 'Alerta creada correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error en AlertaController@store: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear la alerta');
        }
    }

    // Actualizar una alerta por ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'sensor' => 'required|string',
            'mensaje' => 'required|string',
            'resuelta' => 'required|boolean'
        ]);
    
        $user = session()->get('user'); // Asume que guardas el usuario completo en la sesión
    
        $data = [
            'sensor' => $request->sensor,
            'mensaje' => $request->mensaje,
            'resuelta' => (bool)$request->resuelta,
            'modificadoPor' => [
                'usuarioId' => $user['_id'] ?? 'unknown',
                'nombre' => $user['nombre'] ?? 'Usuario desconocido'
            ]
        ];
    
        $response = Http::put("http://localhost:3000/alertas/{$id}", $data);
    
        if ($response->successful()) {
            return redirect()->route('alertas.index')
                ->with('success', 'Alerta actualizada correctamente');
        }
    
        return back()->with('error', 'Error al actualizar: ' . $response->json()['message'] ?? 'Error desconocido');
    }

    // Eliminar una alerta por ID
    public function destroy($id)
    {
        try {
            $response = Http::delete("{$this->apiUrl}/{$id}");
            
            if (!$response->successful()) {
                throw new \Exception("Error al eliminar alerta");
            }
            
            return redirect()->route('alertas.index')->with('success', 'Alerta eliminada correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error en AlertaController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la alerta');
        }
    }
} 