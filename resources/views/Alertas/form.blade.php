@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="mb-4">{{ isset($alerta) ? 'Editar Alerta' : 'Crear Nueva Alerta' }}</h1>
    
    <!-- Agregar mensajes de error -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ isset($alerta) ? route('alertas.update', $alerta['_id']) : route('alertas.store') }}" method="POST">
        @csrf
        @if(isset($alerta))
            @method('PUT')
        @endif
        
        <div class="form-group mb-3">
            <label for="sensor" class="text-light">Sensor</label>
            <select class="form-control bg-dark text-light" id="sensor" name="sensor" required>
                <option value="">Seleccione un sensor</option>
                @foreach($sensores as $sensor)
                    <option value="{{ $sensor['_id'] }}" 
                        {{ (isset($alerta) && isset($alerta['sensor']['_id']) && $sensor['_id'] == $alerta['sensor']['_id']) ? 'selected' : '' }}>
                        Sensor ID: {{ $sensor['_id'] }} - Estado: {{ $sensor['estado'] }}
                        @if(isset($sensor['poste']['ubicacion']))
                            - Ubicación: {{ $sensor['poste']['ubicacion'] }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label for="mensaje" class="text-light">Mensaje</label>
            <textarea class="form-control bg-dark text-light" id="mensaje" name="mensaje" rows="3" required>{{ isset($alerta) ? $alerta['mensaje'] : old('mensaje') }}</textarea>
        </div>
        
        <div class="form-group mb-3">
            <label for="resuelta" class="text-light">Estado</label>
            <select class="form-control bg-dark text-light" id="resuelta" name="resuelta" required>
                <option value="0" {{ (isset($alerta) && !$alerta['resuelta']) ? 'selected' : '' }}>Pendiente</option>
                <option value="1" {{ (isset($alerta) && $alerta['resuelta']) ? 'selected' : '' }}>Resuelta</option>
            </select>
        </div>
        
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-outline-light">
                {{ isset($alerta) ? 'Actualizar Alerta' : 'Crear Alerta' }}
            </button>
            
            <a href="{{ route('alertas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection