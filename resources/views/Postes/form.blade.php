@extends('layouts.app')

@section('title', 'Crear Poste')

@section('content')
    <div class="p-4"> <!-- Padding para el contenido -->
        <h1 class="my-4">Crear Nuevo Poste</h1>
        <form action="{{ route('postes.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="ubicacion" class="text-light">Ubicación</label>
                <input type="text" class="form-control bg-dark text-light" id="ubicacion" name="ubicacion" placeholder="Ingrese la ubicación del poste" required>
            </div>
            <div class="form-group mb-3">
                <label for="estado" class="text-light">Estado</label>
                <select class="form-control bg-dark text-light" id="estado" name="estado" required>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="sensores" class="text-light">Sensores</label>
                <select class="form-control bg-dark text-light" id="sensores" name="sensores[]" multiple required>
                    @foreach ($sensores as $sensor)
                        <option value="{{ $sensor['_id'] }}">{{ $sensor['_id'] }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-outline-light">Crear Poste</button>
            <a href="{{ route('postes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
@endsection