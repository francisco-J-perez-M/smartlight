@extends('layouts.app')

@section('title', 'Lista de Postes')

@section('content')
    <div class="container">
        <h1 class="my-4">Lista de Postes</h1>
        <div class="row">
            @foreach ($postes as $poste)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">ID del Poste: {{ $poste['_id'] }}</h5>
                            <p class="card-text">
                                <strong>Estado:</strong>
                                <span class="badge {{ $poste['estado'] === 'activo' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $poste['estado'] }}
                                </span>
                            </p>
                            <p class="card-text">
                                <strong>Sensores:</strong>
                                @if (count($poste['sensores']) > 0)
                                    <ul>
                                        @foreach ($poste['sensores'] as $sensor)
                                            <li>{{ $sensor }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">No hay sensores asociados.</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection