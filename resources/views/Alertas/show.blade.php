@extends('layouts.app')

@section('title', 'Detalles de la Alerta')

@section('content')
<div class="p-4">
    <h1 class="mb-4">Detalles de la Alerta</h1>
    <div class="card bg-secondary text-light">
        <div class="card-body">
            <h5 class="card-title">ID de la Alerta: {{ $alerta['_id'] }}</h5>
            <p class="card-text"><strong>Mensaje:</strong> {{ $alerta['mensaje'] }}</p>
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

            @if ($sensor)
                <hr>
                <h5>Detalles del Sensor</h5>
                <p><strong>Id:</strong> {{ $sensor['_id'] }}</p>
                <p><strong>Id del Poste:</strong> {{ $sensor['poste']['_id'] ?? 'No disponible' }}</p>
                <p><strong>Estado:</strong> {{ $sensor['estado'] ?? 'No disponible' }}</p>
                <p><strong>Última Revisión:</strong> 
                    {{ $sensor['ultimaRevision'] ?? 'No disponible' }}
                </p>
            @else
                <p class="text-warning">No se encontró información del sensor.</p>
            @endif

            @if ($poste)
                <hr>
                <h5>Detalles del Poste</h5>
                <p><strong>Id:</strong> {{ $poste['_id'] }}</p>
                <p><strong>Ubicación:</strong> {{ $poste['ubicacion'] ?? 'No disponible' }}</p>
                <p><strong>Sensores:</strong> 
                    {{ implode(', ', array_map(fn($s) => $s['_id'], $poste['sensores'] ?? [])) }}
                </p>
                <p><strong>Estado:</strong> {{ $poste['estado'] ?? 'No disponible' }}</p>
            @else
                <p class="text-warning">No se encontró información del poste.</p>
            @endif
        </div>
    </div>
    <a href="{{ route('alertas.index') }}" class="btn btn-outline-light mt-3">Volver a la lista</a>
</div>
@endsection
