@extends('layouts.app')

@section('title', 'Lista de Postes')

@section('content')
    <div class="p-4"> <!-- Padding para el contenido -->
        <h1 class="my-4">Lista de Postes</h1>
        <a href="{{ route('postes.create') }}" class="btn btn-outline-light mb-3">Agregar Poste</a>
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
                                <a href="{{ route('postes.show', ['id' => $poste['_id']]) }}" class="btn btn-outline-light">
                                    Consultar
                                </a>
                                <a href="{{ route('postes.edit', $poste['_id']) }}" class="btn btn-outline-warning">
                                    Editar
                                </a>
                                <form action="{{ route('postes.destroy', $poste['_id']) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este poste?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection