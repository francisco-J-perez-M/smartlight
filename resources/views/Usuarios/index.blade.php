@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
    <div class="p-4">
        <h1 class="my-4">Lista de Usuarios</h1>

        <!-- Botones y formularios existentes -->
        <div class="d-flex justify-content-between mb-3">
            @if(Session::get('rol') === 'admin')
                <a href="{{ route('usuarios.create') }}" class="btn btn-outline-light">Agregar Usuario</a>
            @endif
            <a href="{{ route('usuarios.export') }}" class="btn btn-outline-success">Exportar a Excel</a>
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

        <!-- Campo de búsqueda con estilo mejorado -->
        <div class="form-group mb-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark">
                        <i class="fas fa-search text-light"></i> <!-- Ícono de lupa -->
                    </span>
                </div>
                <input type="text" id="searchInput" class="form-control bg-dark text-light border-dark" placeholder="Buscar por nombre...">
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Contenedor de usuarios -->
        <div class="row" id="usuariosContainer">
            @foreach($usuarios as $usuario)
                <div class="col-md-4 mb-4 usuario-card">
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

<!-- Paginación con clases personalizadas -->
<div class="d-flex justify-content-center mt-4">
    {{ $usuarios->links('vendor.pagination.bootstrap-5') }}
</div>

    </div>

    <!-- Script para la búsqueda con AJAX -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.trim(); // Obtén el valor de búsqueda

            // Realiza una solicitud AJAX al servidor
            fetch(`{{ route('usuarios.search') }}?search=${searchValue}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('usuariosContainer');
                    container.innerHTML = ''; // Limpia el contenedor de usuarios

                    // Muestra los resultados filtrados
                    data.forEach(usuario => {
                        const card = `
                            <div class="col-md-4 mb-4 usuario-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="card-title">${usuario.nombre}</h2>
                                        <p class="card-text"><strong>Email:</strong> ${usuario.email}</p>
                                        <p class="card-text"><strong>Rol:</strong> ${usuario.rol}</p>
                                        <p class="card-text"><strong>ID:</strong> ${usuario._id}</p>
                                        <a href="{{ route('usuarios.show', '') }}/${usuario._id}" class="btn btn-outline-light">Detalles</a>
                                        @if(Session::get('rol') === 'admin')
                                            <a href="{{ route('usuarios.edit', '') }}/${usuario._id}" class="btn btn-outline-warning">Editar</a>
                                            <form action="{{ route('usuarios.destroy', '') }}/${usuario._id}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        `;
                        container.innerHTML += card; // Agrega la tarjeta al contenedor
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <!-- Incluir FontAwesome para el ícono de búsqueda -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection