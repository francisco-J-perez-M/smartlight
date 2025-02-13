@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
    <h1>Crear Usuario</h1>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol:</label>
            <select name="rol" id="rol" class="form-select" required>
                <option value="tecnico">Técnico</option>
                <option value="admin">Admin</option>
                <option value="usuario">Usuario</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
@endsection