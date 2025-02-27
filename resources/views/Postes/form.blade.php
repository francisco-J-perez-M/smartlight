@extends('layouts.app')

@section('title', isset($poste) ? 'Editar Poste' : 'Crear Poste')

@section('content')
    <div class="p-4">
        <h1 class="my-4">{{ isset($poste) ? 'Editar Poste' : 'Crear Nuevo Poste' }}</h1>

        <form action="{{ isset($poste) ? route('postes.update', $poste['_id']) : route('postes.store') }}" method="POST">
            @csrf
            @if(isset($poste))
                @method('PUT')
            @endif

            <div class="form-group mb-3">
                <label for="ubicacion" class="text-light">Ubicación</label>
                <input type="text" class="form-control bg-dark text-light" id="ubicacion" name="ubicacion" 
                       value="{{ old('ubicacion', $poste['ubicacion'] ?? '') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="estado" class="text-light">Estado</label>
                <select class="form-control bg-dark text-light" id="estado" name="estado" required>
                    <option value="activo" {{ (old('estado', $poste['estado'] ?? '') == 'activo') ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ (old('estado', $poste['estado'] ?? '') == 'inactivo') ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="sensores" class="text-light">Sensores</label>
                <select class="form-control bg-dark text-light" id="sensores" name="sensores[]" multiple required>
                    @foreach ($sensores as $sensor)
                        <option value="{{ $sensor['_id'] }}" 
                            {{ isset($poste) && in_array($sensor['_id'], array_column($poste['sensores'] ?? [], '_id')) ? 'selected' : '' }}>
                            {{ $sensor['_id'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-outline-light">{{ isset($poste) ? 'Actualizar' : 'Crear' }} Poste</button>
            <a href="{{ route('postes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
@endsection
