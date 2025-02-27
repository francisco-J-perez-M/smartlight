@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
    <div class="p-4"> <!-- Padding para el contenido -->
        <h1 class="my-4">Lista de Usuarios</h1>

        <!-- Botón "Agregar Usuario" solo para admin -->
        @if(Session::get('rol') === 'admin')
            <a href="{{ route('usuarios.create') }}" class="btn btn-outline-light mb-3">Agregar Usuario</a>
        @endif

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
                        <div class="card-body">
                            <h2 class="card-title">{{ $usuario['nombre'] }}</h2>
                            <p class="card-text"><strong>Email:</strong> {{ $usuario['email'] }}</p>
                            <p class="card-text"><strong>Rol:</strong> {{ $usuario['rol'] }}</p>
                            <p class="card-text"><strong>ID:</strong> {{ $usuario['_id'] }}</p>
                            <a href="{{ route('usuarios.show', $usuario['_id']) }}" class="btn btn-outline-light mb-3">Detalles</a>

                            <!-- Botones de editar y eliminar solo para admin -->
                            @if(Session::get('rol') === 'admin')
                                <a href="{{ route('usuarios.edit', $usuario['_id']) }}" class="btn btn-outline-warning mb-3">Editar</a>
                                <form action="{{ route('usuarios.destroy', $usuario['_id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger mb-3">Eliminar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection