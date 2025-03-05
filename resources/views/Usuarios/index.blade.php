@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
    <div class="p-4">
        <h1 class="my-4">Lista de Usuarios</h1>

        <div class="d-flex justify-content-between mb-3">
            @if(Session::get('rol') === 'admin')
                <a href="{{ route('usuarios.create') }}" class="btn btn-outline-light">Agregar Usuario</a>
            @endif

            <!-- Botón para exportar a Excel -->
            <a href="{{ route('usuarios.export') }}" class="btn btn-outline-success">Exportar a Excel</a>

            <!-- Botón para ver gráficas -->
            <a href="{{ route('graficas.usuarios') }}" class="btn btn-outline-info">Ver Gráficas</a>
        </div>

        <!-- Formulario para importar desde Excel -->
        <form action="{{ route('usuarios.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="file">Importar Usuarios desde Excel</label>
                <input type="file" name="file" class="form-control-file" required>
            </div>
            <button type="submit" class="btn btn-outline-primary">Importar</button>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
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
                            <a href="{{ route('usuarios.show', $usuario['_id']) }}" class="btn btn-outline-light">Detalles</a>

                            @if(Session::get('rol') === 'admin')
                                <a href="{{ route('usuarios.edit', $usuario['_id']) }}" class="btn btn-outline-warning">Editar</a>
                                <form action="{{ route('usuarios.destroy', $usuario['_id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection