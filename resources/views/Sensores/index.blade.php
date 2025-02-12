@extends('layouts.app')

@section('title', 'Lista de Sensores')

@section('content')
    <div class="container">
        <h1 class="my-4">Lista de Sensores</h1>
        <div class="row">
            @foreach ($sensores as $sensor)
                <div class="col-md-4 mb-4">
                    <div class="card">
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
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection