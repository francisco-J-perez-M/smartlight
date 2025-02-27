@extends('layouts.app')

@section('content')
<div class="p-4"> <!-- Padding para el contenido -->
    <h1 class="mb-4">{{ isset($sensor) ? 'Editar Sensor' : 'Crear Nuevo Sensor' }}</h1>


    <form action="{{ isset($sensor) ? route('sensores.update', $sensor['_id']) : route('sensores.store') }}" method="POST">
        @csrf
        @if(isset($sensor))
            @method('PUT')
        @endif

        <div class="form-group mb-3">
            <label for="poste_id" class="text-light">Poste</label>
            <select name="poste" id="poste" class="form-control bg-dark text-light" required>
                @foreach($postes as $poste)
                    <option value="{{ $poste['_id'] }}" {{ isset($sensor) && $sensor['poste']['_id'] == $poste['_id'] ? 'selected' : '' }}>
                        {{ $poste['_id'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="estado" class="text-light">Estado</label>
            <input type="text" name="estado" id="estado" class="form-control bg-dark text-light"
                value="{{ $sensor['estado'] ?? '' }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="ultimaRevision" class="text-light">Última Revisión</label>
            <input type="datetime-local" name="ultimaRevision" id="ultimaRevision" class="form-control bg-dark text-light"
                value="{{ isset($sensor['ultimaRevision']) ? \Carbon\Carbon::parse($sensor['ultimaRevision'])->format('Y-m-d\TH:i') : '' }}" required>
        </div>

        <button type="submit" class="btn btn-outline-light">{{ isset($sensor) ? 'Actualizar' : 'Crear' }}</button>
        <a href="{{ route('sensores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
