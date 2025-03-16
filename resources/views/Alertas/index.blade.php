@extends('layouts.app')

@section('title', 'Lista de Alertas')

@section('content')
    <div class="p-4">
        <h1 class="my-4">Lista de Alertas</h1>

        <!-- Botón "Agregar Alerta" solo para admin -->
        <div class="d-flex justify-content-between mb-3">
            @if(Session::get('rol') === 'admin')
                <a href="{{ route('alertas.create') }}" class="btn btn-outline-light">Agregar Alerta</a>
            @endif
            <!-- Botón para exportar a Excel -->
            <a href="{{ route('alertas.export') }}" class="btn btn-outline-success">Exportar a Excel</a>
            <!-- Botón para ver gráficas de alertas -->
            <a href="{{ route('graficas.alertas') }}" class="btn btn-outline-info">Ver Gráficas</a>
        </div>

        <!-- Formulario para importar desde Excel -->
        <form action="{{ route('alertas.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="file">Importar Alertas desde Excel</label>
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
                <input type="text" id="searchInput" class="form-control bg-dark text-light border-dark" placeholder="Buscar por ID...">
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Contenedor de alertas -->
        <div class="row" id="alertasContainer">
            @foreach($alertas as $alerta)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">ID de la Alerta: {{ $alerta['_id'] }}</h5>
                            <p class="card-text">
                                <strong>Mensaje:</strong> {{ $alerta['mensaje'] }}
                            </p>
                            <p class="card-text">
                                <strong>Estado de la Alerta:</strong>
                                <span class="badge {{ $alerta['resuelta'] ? 'badge-success' : 'badge-danger' }}">
                                    {{ $alerta['resuelta'] ? 'Resuelta' : 'Pendiente' }}
                                </span>
                            </p>
                            <p class="card-text">
                                <strong>Fecha de la Alerta:</strong>
                                {{ \Carbon\Carbon::parse($alerta['fecha'])->format('d/m/Y H:i:s') }}
                            </p>
                            <!-- Botones de acción -->
                            <a href="{{ route('alertas.show', $alerta['_id']) }}" class="btn btn-outline-light mb-3">Detalles</a>

                            <!-- Botones de "Editar" y "Eliminar" solo para admin -->
                            @if(Session::get('rol') === 'admin')
                                <a href="{{ route('alertas.edit', $alerta['_id']) }}" class="btn btn-outline-warning mb-3">Editar</a>
                                <form action="{{ route('alertas.destroy', $alerta['_id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger mb-3">Eliminar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación con clases personalizadas -->
        <div class="d-flex justify-content-center mt-4">
            {{ $alertas->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <!-- Script para la búsqueda con AJAX -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.trim(); // Obtén el valor de búsqueda

            // Realiza una solicitud AJAX al servidor
            fetch(`{{ route('alertas.search') }}?search=${searchValue}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('alertasContainer');
                    container.innerHTML = ''; // Limpia el contenedor de alertas

                    // Muestra los resultados filtrados
                    data.forEach(alerta => {
                        const card = `
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">ID de la Alerta: ${alerta._id}</h5>
                                        <p class="card-text">
                                            <strong>Mensaje:</strong> ${alerta.mensaje}
                                        </p>
                                        <p class="card-text">
                                            <strong>Estado de la Alerta:</strong>
                                            <span class="badge ${alerta.resuelta ? 'badge-success' : 'badge-danger'}">
                                                ${alerta.resuelta ? 'Resuelta' : 'Pendiente'}
                                            </span>
                                        </p>
                                        <p class="card-text">
                                            <strong>Fecha de la Alerta:</strong>
                                            ${new Date(alerta.fecha).toLocaleString()}
                                        </p>
                                        <!-- Botones de acción -->
                                        <a href="{{ route('alertas.show', '') }}/${alerta._id}" class="btn btn-outline-light mb-3">Detalles</a>

                                        <!-- Botones de "Editar" y "Eliminar" solo para admin -->
                                        @if(Session::get('rol') === 'admin')
                                            <a href="{{ route('alertas.edit', '') }}/${alerta._id}" class="btn btn-outline-warning mb-3">Editar</a>
                                            <form action="{{ route('alertas.destroy', '') }}/${alerta._id}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger mb-3">Eliminar</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        `;
                        container.innerHTML += card; // Agrega la tarjeta al contenedor
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <!-- Incluir FontAwesome para el ícono de búsqueda -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection