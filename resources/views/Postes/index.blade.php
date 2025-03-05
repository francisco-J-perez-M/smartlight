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

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            @foreach ($postes as $poste)
                <div class="col-md-4 mb-4">
                    <div class="card bg-secondary text-light">
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
    </div>
@endsection