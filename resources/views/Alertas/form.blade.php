@extends('layouts.app')

@section('content')
<div class="p-4"> <!-- Padding para el contenido -->
    <h1 class="mb-4">Crear Nueva Alerta</h1>
    <form action="{{ route('alertas.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="sensor" class="text-light">Sensor</label>
            <select class="form-control bg-dark text-light" id="sensor" name="sensor" required>
                <option value="">Seleccione un sensor</option>
                @foreach ($sensores as $sensor)
                    <option value="{{ $sensor['_id'] }}">
                        Sensor ID: {{ $sensor['_id'] }} - Estado: {{ $sensor['estado'] }}
                        @if (isset($sensor['poste']['ubicacion']))
                            - Ubicación: {{ $sensor['poste']['ubicacion'] }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="mensaje" class="text-light">Mensaje</label>
            <textarea class="form-control bg-dark text-light" id="mensaje" name="mensaje" rows="3" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="resuelta" class="text-light">Resuelta</label>
            <select class="form-control bg-dark text-light" id="resuelta" name="resuelta">
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <button type="submit" class="btn btn-outline-light">Crear Alerta</button>
    </form>
</div>
@endsection