@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
    <h1 class="my-4">Lista de Usuarios</h1>
    <div class="row">
        @foreach($usuarios as $usuario)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <h2>{{ $usuario['nombre'] }}</h2>
                    <p><strong>Emaill:</strong> {{ $usuario['email'] }}</p>
                    <p><strong>Rol:</strong> {{ $usuario['rol'] }}</p>
                    <p><strong>ID:</strong> {{ $usuario['_id'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection