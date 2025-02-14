@extends('layouts.app')

@section('title', 'Crear Poste')

@section('content')
    <div class="container">
        <h1 class="my-4">Crear Nuevo Poste</h1>
        <form action="{{ route('postes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ingrese la ubicación del poste" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <select class="form-control" id="estado" name="estado" required>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sensores">Sensores</label>
                <select class="form-control" id="sensores" name="sensores[]" multiple required>
                    @foreach ($sensores as $sensor)
                        <option value="{{ $sensor['_id'] }}">{{ $sensor['_id'] }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear Poste</button>
            <a href="{{ route('postes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection