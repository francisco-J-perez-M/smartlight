@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Alerta</h1>
    <form action="{{ route('alertas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="sensor">Sensor</label>
            <select class="form-control" id="sensor" name="sensor" required>
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
        <div class="form-group">
            <label for="mensaje">Mensaje</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="resuelta">Resuelta</label>
            <select class="form-control" id="resuelta" name="resuelta">
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Alerta</button>
    </form>
</div>
@endsection