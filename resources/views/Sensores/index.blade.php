@extends('layouts.app')

@section('title', 'Lista de Sensores')

@section('content')
    <div class="p-4">
        <h1 class="my-4">Lista de Sensores</h1>

        <!-- Botón "Agregar Sensor" solo para admin -->
        <div class="d-flex justify-content-between mb-3">
            @if(Session::get('rol') === 'admin')
                <a href="{{ route('sensores.create') }}" class="btn btn-outline-light">Agregar Sensor</a>
            @endif
        
            <!-- Botón para exportar a Excel -->
            <a href="{{ route('sensores.export') }}" class="btn btn-outline-success">Exportar a Excel</a>
        
            <!-- Botón para ver gráficas de sensores -->
            <a href="{{ route('graficas.sensores') }}" class="btn btn-outline-info">Ver Gráficas</a>
        </div>

        <!-- Formulario para importar desde Excel -->
        <form action="{{ route('sensores.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="file">Importar Sensores desde Excel</label>
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

        <!-- Contenedor de sensores -->
        <div class="row" id="sensoresContainer">
            @foreach ($sensores as $sensor)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">ID del Sensor: {{ $sensor['_id'] }}</h5>
                            <p class="card-text">
                                <strong>Estado del Sensor:</strong>
                                <span class="badge {{ $sensor['estado'] === 'funcionando' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $sensor['estado'] }}
                                </span>
                            </p>
                            <p class="card-text">
                                <strong>Última Revisión:</strong>
                                {{ \Carbon\Carbon::parse($sensor['ultimaRevision'])->format('d/m/Y H:i:s') }}
                            </p>
                            <div class="d-flex gap-2">
                                <!-- Botón "Consultar" visible para todos -->
                                <a href="{{ route('sensores.show', ['id' => $sensor['_id']]) }}" class="btn btn-outline-light">
                                    Consultar
                                </a>

                                <!-- Botones de "Editar" y "Eliminar" solo para admin -->
                                @if(Session::get('rol') === 'admin')
                                    <a href="{{ route('sensores.edit', $sensor['_id']) }}" class="btn btn-outline-warning">
                                        Editar
                                    </a>
                                    <form action="{{ route('sensores.destroy', $sensor['_id']) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este sensor?')">
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
            {{ $sensores->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <!-- Script para la búsqueda con AJAX -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.trim(); // Obtén el valor de búsqueda

            // Realiza una solicitud AJAX al servidor
            fetch(`{{ route('sensores.index') }}?search=${searchValue}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('sensoresContainer').innerHTML;
                    document.getElementById('sensoresContainer').innerHTML = newContent;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <!-- Incluir FontAwesome para el ícono de búsqueda -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection