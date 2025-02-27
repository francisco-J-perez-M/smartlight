@extends('layouts.app')

@section('title', 'Lista de Alertas')

@section('content')
    <div class="p-4"> <!-- Padding para el contenido -->
        <h1 class="my-4">Lista de Alertas</h1>

        <!-- Botón "Agregar Alerta" solo para admin -->
        @if(Session::get('rol') === 'admin')
            <a href="{{ route('alertas.create') }}" class="btn btn-outline-light mb-3">Agregar Alerta</a>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            @foreach($alertas as $alerta)
                <div class="col-md-4 mb-4">
                    <div class="card bg-secondary text-light">
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
    </div>
@endsection