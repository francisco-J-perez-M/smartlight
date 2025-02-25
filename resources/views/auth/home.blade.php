@extends('layouts.app')

@section('content')
<div class="p-4"> <!-- Padding para el contenido -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg bg-secondary text-light"> <!-- Fondo oscuro y texto claro -->
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Dashboard</h4>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-center">Bienvenido, {{ session('user')['nombre'] }}</h3>
                    <p class="text-center">Tu rol es: <strong>{{ session('user')['rol'] }}</strong></p>

                    <hr class="bg-light"> <!-- Línea divisoria clara -->

                    @if (session('user')['rol'] === 'admin')
                        <h4 class="text-center">Funciones de Administrador</h4>
                        <ul class="list-group">
                            <li class="list-group-item bg-dark text-light text-center">
                                <a href="{{ route('postes.create') }}" class="btn btn-outline-light w-100">Crear Nueva Luminaria</a>
                            </li>
                            <li class="list-group-item bg-dark text-light text-center">
                                <a href="{{ route('postes.index') }}" class="btn btn-outline-light w-100">Ver Listado de Luminarias</a>
                            </li>
                            <li class="list-group-item bg-dark text-light text-center">
                                <a href="#" class="btn btn-outline-light w-100">Editar Luminaria (Ejemplo ID 1)</a>
                            </li>
                            <li class="list-group-item bg-dark text-light text-center">
                                <a href="{{ route('postes.show', 1) }}" class="btn btn-outline-light w-100">Ver Detalles de Luminaria (Ejemplo ID 1)</a>
                            </li>
                        </ul>
                    @elseif (session('user')['rol'] === 'tecnico')
                        <h4 class="text-center">Funciones de Técnico</h4>
                        <ul class="list-group">
                            <li class="list-group-item bg-dark text-light text-center">
                                <a href="{{ route('postes.index') }}" class="btn btn-outline-light w-100">Ver Listado de Luminarias</a>
                            </li>
                            <li class="list-group-item bg-dark text-light text-center">
                                <a href="{{ route('postes.show', 1) }}" class="btn btn-outline-light w-100">Ver Detalles de Luminaria (Ejemplo ID 1)</a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection