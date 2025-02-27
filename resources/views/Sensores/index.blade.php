@extends('layouts.app')

@section('title', 'Lista de Sensores')

@section('content')
    <div class="p-4"> <!-- Padding para el contenido -->
        <h1 class="my-4">Lista de Sensores</h1>

        <!-- Botones de acción -->
        <a href="{{ route('sensores.create') }}" class="btn btn-outline-light mb-3">Agregar Sensor</a>
        
        <div class="row">
            @foreach ($sensores as $sensor)
                <div class="col-md-4 mb-4">
                    <div class="card bg-secondary text-light">
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
                                <a href="{{ route('sensores.show', ['id' => $sensor['_id']]) }}" class="btn btn-outline-light">
                                    Consultar
                                </a>
                                <a href="{{ route('sensores.edit', $sensor['_id']) }}" class="btn btn-outline-warning">
                                    Editar
                                </a>
                                <form action="{{ route('sensores.destroy', $sensor['_id']) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este sensor?')">
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
