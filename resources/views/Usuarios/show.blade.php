@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
    <div class="p-4"> <!-- Padding para el contenido -->
        <h1 class="mb-4">Detalles del Usuario</h1>

        <!-- Tarjeta con los detalles del usuario -->
        <div class="card bg-secondary text-light">
            <div class="card-body">
                <p class="card-text"><strong>Nombre:</strong> {{ $usuario['nombre'] }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $usuario['email'] }}</p>
                <p class="card-text"><strong>Rol:</strong> {{ $usuario['rol'] }}</p>
            </div>
        </div>

        <!-- Botón para volver a la lista de usuarios -->
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-light mt-3">Volver a la lista de usuarios</a>
    </div>
@endsection