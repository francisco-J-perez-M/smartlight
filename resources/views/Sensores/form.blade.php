<!-- resources/views/sensores/form.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Sensor</h1>
    <form action="{{ route('sensores.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="poste_id">Poste</label>
            <select name="poste" id="poste" class="form-control" required>
                @foreach($postes as $poste)
                    <option value="{{ $poste['_id'] }}">{{ $poste['_id'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" name="estado" id="estado" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="ultimaRevision">Última Revisión</label>
            <input type="datetime-local" name="ultimaRevision" id="ultimaRevision" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Sensor</button>
    </form>
</div>
@endsection