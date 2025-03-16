@extends('layouts.app')

@section('title', 'Lista de Postes')

@section('content')
    <div class="p-4">
        <h1 class="my-4">Lista de Postes</h1>

        <!-- Botón "Agregar Poste" solo para admin -->
        <div class="d-flex justify-content-between mb-3">
            @if(Session::get('rol') === 'admin')
                <a href="{{ route('postes.create') }}" class="btn btn-outline-light">Agregar Poste</a>
            @endif
        
            <!-- Botón para exportar a Excel -->
            <a href="{{ route('postes.export') }}" class="btn btn-outline-success">Exportar a Excel</a>
        
            <!-- Botón para ver gráficas de postes -->
            <a href="{{ route('graficas.postes') }}" class="btn btn-outline-info">Ver Gráficas</a>
        </div>

        <!-- Formulario para importar desde Excel -->
        <form action="{{ route('postes.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="file">Importar Postes desde Excel</label>
                <input type="file" name="file" class="form-control-file" required>
            </div>
            <button type="submit" class="btn btn-outline-primary">Importar</button>
        </form>

        <!-- Campo de búsqueda con estilo mejorado -->
        <div class="form-group mb-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark">
                        <i class="fas fa-search text-light"></i> <!-- Ícono de lupa -->
                    </span>
                </div>
                <input type="text" id="searchInput" class="form-control bg-dark text-light border-dark" placeholder="Buscar por ID..." value="{{ $search }}">
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Contenedor de postes -->
        <div class="row" id="postesContainer">
            @foreach ($postes as $poste)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                ID del Poste: 
                                {{ is_array($poste['_id'] ?? null) ? json_encode($poste['_id']) : ($poste['_id'] ?? 'No disponible') }}
                            </h5>
                            <p class="card-text">
                                <strong>Ubicación:</strong> 
                                {{ is_array($poste['ubicacion'] ?? null) ? 'No especificada' : ($poste['ubicacion'] ?? 'No especificada') }}
                            </p>
                            <p class="card-text">
                                <strong>Estado:</strong>
                                @php
                                    $estado = is_array($poste['estado'] ?? null) ? 'inactivo' : ($poste['estado'] ?? 'inactivo');
                                    $claseEstado = $estado === 'activo' ? 'badge-success' : 'badge-danger';
                                @endphp
                                <span class="badge {{ $claseEstado }}">
                                    {{ $estado }}
                                </span>
                            </p>
                            <p class="card-text">
                                <strong>Sensores:</strong>
                                @if (!empty($poste['sensores']) && is_array($poste['sensores']) && count($poste['sensores']) > 0)
                                    <ul>
                                        @foreach ($poste['sensores'] as $sensor)
                                            <li>
                                                {{ is_array($sensor) && isset($sensor['_id']) ? $sensor['_id'] : 'ID no disponible' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">No hay sensores asociados.</span>
                                @endif
                            </p>
                            <div class="d-flex gap-2">
                                <!-- Botón "Consultar" visible para todos -->
                                <a href="{{ route('postes.show', ['id' => $poste['_id']]) }}" class="btn btn-outline-light">
                                    Consultar
                                </a>

                                <!-- Botones de "Editar" y "Eliminar" solo para admin -->
                                @if(Session::get('rol') === 'admin')
                                    <a href="{{ route('postes.edit', $poste['_id']) }}" class="btn btn-outline-warning">
                                        Editar
                                    </a>
                                    <form action="{{ route('postes.destroy', $poste['_id']) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este poste?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación con clases personalizadas -->
        <div class="d-flex justify-content-center mt-4">
            {{ $postes->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <!-- Script para la búsqueda con AJAX -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.trim(); // Obtén el valor de búsqueda

            // Realiza una solicitud AJAX al servidor
            fetch(`{{ route('postes.index') }}?search=${searchValue}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('postesContainer').innerHTML;
                    document.getElementById('postesContainer').innerHTML = newContent;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <!-- Incluir FontAwesome para el ícono de búsqueda -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection