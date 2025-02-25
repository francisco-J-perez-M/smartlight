<!-- resources/views/sensores/form.blade.php -->

@extends('layouts.app')

@section('content')
<div class="p-4"> <!-- Padding para el contenido -->
    <h1 class="mb-4">Crear Nuevo Sensor</h1>
    <form action="{{ route('sensores.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="poste_id" class="text-light">Poste</label>
            <select name="poste" id="poste" class="form-control bg-dark text-light" required>
                @foreach($postes as $poste)
                    <option value="{{ $poste['_id'] }}">{{ $poste['_id'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="estado" class="text-light">Estado</label>
            <input type="text" name="estado" id="estado" class="form-control bg-dark text-light" required>
        </div>
        <div class="form-group mb-3">
            <label for="ultimaRevision" class="text-light">Última Revisión</label>
            <input type="datetime-local" name="ultimaRevision" id="ultimaRevision" class="form-control bg-dark text-light" required>
        </div>
        <button type="submit" class="btn btn-outline-light">Crear Sensor</button>
    </form>
</div>
@endsection