@extends('layouts.app')

@section('title', 'Detalles de la Alerta')

@section('content')
<div class="p-4">
    <h1 class="mb-4">Detalles de la Alerta</h1>
    <div class="card bg-secondary text-light">
        <div class="card-body">
            <h5 class="card-title">ID de la Alerta: {{ $alerta['_id'] }}</h5>
            <p class="card-text">
                <strong>Sensor:</strong> {{ $alerta['sensor']['_id'] }} - Estado: {{ $alerta['sensor']['estado'] }}
            </p>
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
    <a href="{{ route('alertas.index') }}" class="btn btn-outline-light mt-3">Volver a la lista</a>
</div>
@endsection