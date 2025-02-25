@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Detalles del Usuario</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $usuario['nombre'] }}</p>
                <p><strong>Email:</strong> {{ $usuario['email'] }}</p>
                <p><strong>Rol:</strong> {{ $usuario['rol'] }}</p>
            </div>
        </div>

        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">Volver a la lista de usuarios</a>
    </div>
@endsection