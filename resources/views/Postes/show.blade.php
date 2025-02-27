@extends('layouts.app')

@section('title', 'Detalles del Poste')

@section('content')
    <div class="p-4"> 
        <h1 class="mb-4">Detalles del Poste</h1>

        <div class="card bg-secondary text-light">
            <div class="card-body">
                <p class="card-text"><strong>Id:</strong> {{ $poste['_id'] ?? 'N/A' }}</p>
                <p class="card-text"><strong>Ubicación:</strong> {{ $poste['ubicacion'] ?? 'N/A' }}</p>
                <p class="card-text"><strong>Sensores:</strong> 
                    {{ implode(', ', array_map(fn($s) => $s['_id'], $poste['sensores'] ?? [])) }}
                </p>               
                <p class="card-text"><strong>Estado:</strong> {{ $poste['estado'] ?? 'N/A' }}</p>
            </div>
        </div>
        

        <a href="{{ route('postes.index') }}" class="btn btn-outline-light mt-3">Volver a la lista de Postes</a>
    </div>
@endsection
