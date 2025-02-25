@extends('layouts.app')

@section('title', isset($usuario) ? 'Editar Usuario' : 'Crear Usuario')

@section('content')
    <div class="p-4"> <!-- Padding para el contenido -->
        <h1 class="mb-4">{{ isset($usuario) ? 'Editar Usuario' : 'Crear Usuario' }}</h1>

        <form action="{{ isset($usuario) ? route('usuarios.update', $usuario['_id']) : route('usuarios.store') }}" method="POST">
            @csrf
            @if(isset($usuario))
                @method('PUT')
            @endif

            <!-- Campo Nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label text-light">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control bg-dark text-light" value="{{ isset($usuario) ? $usuario['nombre'] : '' }}" required>
            </div>

            <!-- Campo Email -->
            <div class="mb-3">
                <label for="email" class="form-label text-light">Email:</label>
                <input type="email" name="email" id="email" class="form-control bg-dark text-light" value="{{ isset($usuario) ? $usuario['email'] : '' }}" required>
            </div>

            <!-- Campo Contraseña -->
            <div class="mb-3">
                <label for="password" class="form-label text-light">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control bg-dark text-light" {{ isset($usuario) ? '' : 'required' }}>
                @if(isset($usuario))
                    <small class="text-muted">Deja este campo en blanco si no deseas cambiar la contraseña.</small>
                @endif
            </div>

            <!-- Campo Rol -->
            <div class="mb-3">
                <label for="rol" class="form-label text-light">Rol:</label>
                <select name="rol" id="rol" class="form-select bg-dark text-light" required>
                    <option value="tecnico" {{ (isset($usuario) && $usuario['rol'] == 'tecnico') ? 'selected' : '' }}>Técnico</option>
                    <option value="admin" {{ (isset($usuario) && $usuario['rol'] == 'admin') ? 'selected' : '' }}>Admin</option>
                    <option value="usuario" {{ (isset($usuario) && $usuario['rol'] == 'usuario') ? 'selected' : '' }}>Usuario</option>
                </select>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-outline-light">
                {{ isset($usuario) ? 'Actualizar Usuario' : 'Crear Usuario' }}
            </button>
        </form>
    </div>
@endsection