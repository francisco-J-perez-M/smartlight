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

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
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

        <!-- Paginación con colores personalizados -->
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Paginación de sensores">
                <ul class="pagination">
                    <!-- Botón "Anterior" -->
                    @if($currentPage > 1)
                        <li class="page-item">
                            <a class="page-link bg-dark text-light" href="{{ route('sensores.index', ['page' => $currentPage - 1]) }}" aria-label="Anterior">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link bg-secondary text-light" aria-hidden="true">&laquo;</span>
                        </li>
                    @endif

                    <!-- Números de página -->
                    @for($i = 1; $i <= $totalPages; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link bg-dark text-light" href="{{ route('sensores.index', ['page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Botón "Siguiente" -->
                    @if($currentPage < $totalPages)
                        <li class="page-item">
                            <a class="page-link bg-dark text-light" href="{{ route('sensores.index', ['page' => $currentPage + 1]) }}" aria-label="Siguiente">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link bg-secondary text-light" aria-hidden="true">&raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

    <!-- Estilos personalizados para la paginación -->
    <style>
        .page-link {
            background-color: #343a40; /* Fondo oscuro */
            color: #ffffff; /* Texto blanco */
            border: 1px solid #454d55; /* Borde oscuro */
        }

        .page-link:hover {
            background-color: #23272b; /* Fondo oscuro más claro al pasar el mouse */
            color: #ffffff;
        }

        .page-item.active .page-link {
            background-color: #007bff; /* Fondo azul para la página activa */
            border-color: #007bff;
        }

        .page-item.disabled .page-link {
            background-color: #6c757d; /* Fondo gris para botones deshabilitados */
            color: #ffffff;
        }
    </style>
@endsection