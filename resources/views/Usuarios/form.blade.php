@extends('layouts.app')

@section('title', isset($usuario) ? 'Editar Usuario' : 'Crear Usuario')

@section('content')
    <h1>{{ isset($usuario) ? 'Editar Usuario' : 'Crear Usuario' }}</h1>

    <form action="{{ isset($usuario) ? route('usuarios.update', $usuario['_id']) : route('usuarios.store') }}" method="POST">
        @csrf
        @if(isset($usuario))
            @method('PUT')
        @endif
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ isset($usuario) ? $usuario['nombre'] : '' }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ isset($usuario) ? $usuario['email'] : '' }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control" {{ isset($usuario) ? '' : 'required' }}>
            @if(isset($usuario))
                <small class="text-muted">Deja este campo en blanco si no deseas cambiar la contraseña.</small>
            @endif
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol:</label>
            <select name="rol" id="rol" class="form-select" required>
                <option value="tecnico" {{ (isset($usuario) && $usuario['rol'] == 'tecnico') ? 'selected' : '' }}>Técnico</option>
                <option value="admin" {{ (isset($usuario) && $usuario['rol'] == 'admin') ? 'selected' : '' }}>Admin</option>
                <option value="usuario" {{ (isset($usuario) && $usuario['rol'] == 'usuario') ? 'selected' : '' }}>Usuario</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($usuario) ? 'Actualizar Usuario' : 'Crear Usuario' }}</button>
    </form>
@endsection