@extends('layouts.app')

@section('title', 'Lista de Alertas')

@section('content')
    <div class="p-4">
        <h1 class="my-4">Lista de Alertas</h1>

        <!-- Botón "Agregar Alerta" solo para admin -->
        <div class="d-flex justify-content-between mb-3">
            @if (Session::get('rol') === 'admin')
                <a href="{{ route('alertas.create') }}" class="btn btn-outline-light">Agregar Alerta</a>
            @endif
            <!-- Botón para exportar a Excel -->
            <a href="{{ route('alertas.export') }}" class="btn btn-outline-success">Exportar a Excel</a>
            <!-- Botón para ver gráficas de alertas -->
            <a href="{{ route('graficas.alertas') }}" class="btn btn-outline-info">Ver Gráficas</a>
        </div>

        <!-- Formulario para importar desde Excel -->
        @if (Session::get('rol') === 'admin')
            <form action="{{ route('alertas.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="form-group">
                    <label for="file">Importar Alertas desde Excel</label>
                    <input type="file" name="file" class="form-control-file" required>
                </div>
                <button type="submit" class="btn btn-outline-primary">Importar</button>
            </form>
        @endif

        <!-- Campo de búsqueda con estilo mejorado -->
        <div class="form-group mb-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark">
                        <i class="fas fa-search text-light"></i>
                    </span>
                </div>
                <input type="text" id="searchInput" class="form-control bg-dark text-light border-dark"
                    placeholder="Buscar por ID, mensaje o estado...">
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Contenedor de alertas -->
        <div class="row" id="alertasContainer">
            @foreach ($alertas as $alerta)
                @if (Session::get('rol') === 'admin' || !$alerta['resuelta'])
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

                                @if (isset($alerta['modificadoPor']) && $alerta['modificadoPor']['nombre'] !== null)
                                    <p class="card-text">
                                        <strong>Modificado por:</strong>
                                        <span class="text-primary">{{ $alerta['modificadoPor']['nombre'] }}</span>
                                        @if (isset($alerta['updatedAt']))
                                            <br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($alerta['updatedAt'])->format('d/m/Y H:i') }}
                                            </small>
                                        @endif
                                    </p>
                                @else
                                    <p class="card-text text-muted">No registra modificaciones</p>
                                @endif

                                <!-- Botones de acción -->
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('alertas.show', $alerta['_id']) }}"
                                        class="btn btn-outline-light">Detalles</a>
                                    @if (!$alerta['resuelta'])
                                        <a href="{{ route('alertas.edit', $alerta['_id']) }}"
                                            class="btn btn-outline-warning">Editar</a>
                                    @endif


                                    @if (Session::get('rol') === 'admin')
                                        <form action="{{ route('alertas.destroy', $alerta['_id']) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"
                                                onclick="return confirm('¿Estás seguro de eliminar esta alerta?')">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Paginación con clases personalizadas -->
        @if ($alertas->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $alertas->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Script para la búsqueda con AJAX -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.trim();

    if (searchValue.length === 0) {
        window.location.reload();
        return;
    }

    fetch(`{{ route('alertas.search') }}?search=${encodeURIComponent(searchValue)}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Asegurar protección CSRF
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Error en la búsqueda');
        return response.json();
    })
    .then(data => {
        const container = document.getElementById('alertasContainer');
        container.innerHTML = '';

        if (data.length === 0) {
            container.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-info">No se encontraron alertas.</div>
                </div>
            `;
            return;
        }

        data.forEach(alerta => {
            const fechaAlerta = new Date(alerta.fecha);
            const fechaModificacion = alerta.updatedAt ? new Date(alerta.updatedAt) : null;

            const card = `
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">ID: ${alerta._id}</h5>
                            <p class="card-text"><strong>Mensaje:</strong> ${alerta.mensaje}</p>
                            <p class="card-text">
                                <strong>Estado:</strong>
                                <span class="badge ${alerta.resuelta ? 'badge-success' : 'badge-danger'}">
                                    ${alerta.resuelta ? 'Resuelta' : 'Pendiente'}
                                </span>
                            </p>
                            <p class="card-text">
                                <strong>Fecha:</strong>
                                ${fechaAlerta.toLocaleDateString('es-ES')} ${fechaAlerta.toLocaleTimeString('es-ES')}
                            </p>
                            ${alerta.modificadoPor?.nombre 
                                ? `<p class="card-text">
                                    <strong>Modificado por:</strong>
                                    <span class="text-primary">${alerta.modificadoPor.nombre}</span>
                                    ${fechaModificacion 
                                        ? `<br><small class="text-muted">
                                            ${fechaModificacion.toLocaleDateString('es-ES')} 
                                            ${fechaModificacion.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'})}
                                        </small>` 
                                        : ''
                                    }
                                </p>`
                                : '<p class="card-text text-muted">No registra modificaciones</p>'
                            }
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('alertas.show', '') }}/${alerta._id}" 
                                   class="btn btn-outline-light btn-sm">Detalles</a>
                                ${!alerta.resuelta 
                                    ? `<a href="{{ route('alertas.edit', '') }}/${alerta._id}" 
                                       class="btn btn-outline-warning btn-sm">Editar</a>`
                                    : ''
                                }
                                @if (Session::get('rol') === 'admin')
                                    <form action="{{ route('alertas.destroy', '') }}/${alerta._id}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('¿Eliminar esta alerta?')">Eliminar</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += card;
        });
    })
    .catch(error => {
        console.error('Error:', error);
        const container = document.getElementById('alertasContainer');
        container.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">Error al cargar los resultados.</div>
            </div>
        `;
    });
});
    </script>

    <!-- Incluir FontAwesome para el ícono de búsqueda -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
