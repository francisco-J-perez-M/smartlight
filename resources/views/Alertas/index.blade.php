@extends('layouts.app')

@section('title', 'Lista de Alertas')

@section('content')
    <div class="p-4"> <!-- Padding para el contenido -->
        <h1 class="my-4">Lista de Alertas</h1>
        <a href="{{ route('alertas.create') }}" class="btn btn-outline-light mb-3">Agregar Alerta</a>
        <div class="row">
            @foreach ($alertas as $alerta)
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
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection