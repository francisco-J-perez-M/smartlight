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

        <!-- Paginación con colores personalizados -->
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Paginación de usuarios">
                <ul class="pagination">
                    <!-- Botón "Anterior" -->
                    @if($currentPage > 1)
                        <li class="page-item">
                            <a class="page-link bg-dark text-light" href="{{ route('usuarios.index', ['page' => $currentPage - 1]) }}" aria-label="Anterior">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link bg-secondary text-light" aria-hidden="true">&laquo;</span>
                        </li>
                    @endif

                    <!-- Números de página -->
                    @for($i = 1; $i <= $totalPages; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link bg-dark text-light" href="{{ route('usuarios.index', ['page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Botón "Siguiente" -->
                    @if($currentPage < $totalPages)
                        <li class="page-item">
                            <a class="page-link bg-dark text-light" href="{{ route('usuarios.index', ['page' => $currentPage + 1]) }}" aria-label="Siguiente">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link bg-secondary text-light" aria-hidden="true">&raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

    <!-- Estilos personalizados para la paginación -->
    <style>
        .page-link {
            background-color: #343a40; /* Fondo oscuro */
            color: #ffffff; /* Texto blanco */
            border: 1px solid #454d55; /* Borde oscuro */
        }

        .page-link:hover {
            background-color: #23272b; /* Fondo oscuro más claro al pasar el mouse */
            color: #ffffff;
        }

        .page-item.active .page-link {
            background-color: #007bff; /* Fondo azul para la página activa */
            border-color: #007bff;
        }

        .page-item.disabled .page-link {
            background-color: #6c757d; /* Fondo gris para botones deshabilitados */
            color: #ffffff;
        }
    </style>
@endsection