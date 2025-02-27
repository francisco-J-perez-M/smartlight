@extends('layouts.app')

@section('title', 'Detalles del Sensor')

@section('content')
    <div class="p-4"> 
        <h1 class="mb-4">Detalles del sensor</h1>

        <div class="card bg-secondary text-light">
            <div class="card-body">
                <p class="card-text"><strong>Id:</strong> {{ $sensor['_id'] ?? 'N/A' }}</p>
                <p class="card-text"><strong>Id del Poste:</strong> {{ $sensor['poste']['_id'] ?? 'N/A' }}</p>
                <p class="card-text"><strong>Estado:</strong> {{ $sensor['estado'] ?? 'N/A' }}</p>
                <p class="card-text"><strong>Última Revisión:</strong> {{ $sensor['ultimaRevision'] ?? 'N/A' }}</p>
            </div>
        </div>

        <a href="{{ route('sensores.index') }}" class="btn btn-outline-light mt-3">Volver a la lista de sensores</a>
    </div>
@endsection
