@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
    <h1 class="my-4">Lista de Usuarios</h1>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Agregar Usuario</a>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <div class="row">
        @foreach($usuarios as $usuario)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <h2>{{ $usuario['nombre'] }}</h2>
                    <p><strong>Email:</strong> {{ $usuario['email'] }}</p>
                    <p><strong>Rol:</strong> {{ $usuario['rol'] }}</p>
                    <p><strong>ID:</strong> {{ $usuario['_id'] }}</p>
                    <a href="{{ route('usuarios.show', $usuario['_id']) }}" class="btn btn-primary mb-3">Detalles</a>
                    <a href="{{ route('usuarios.edit', $usuario['_id']) }}" class="btn btn-warning mb-3">Editar</a>
                    <form action="{{ route('usuarios.destroy', $usuario['_id']) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mb-3">Eliminar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection