@extends('layouts.master')

@section('title', 'Agregar Novedad')

@section('content')
<h1 class="mb-4">Agregar Novedad</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('salud.registrarNovedad') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Seleccionar Bovino</label>
        <select name="animal_id" class="form-select" required>
            <option value="">Seleccione...</option>
            @foreach($bovinos as $bovino)
            <option value="{{ $bovino->id }}">{{ $bovino->code }} - {{ $bovino->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tipo de Novedad</label>
        <select name="type" class="form-select" required>
            <option value="">Seleccione...</option>
            <option value="accidente">Accidente</option>
            <option value="enfermedad">Enfermedad</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Reportado por</label>
        <input type="text" name="reported_by" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Fecha</label>
        <input type="date" name="date" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar Novedad</button>
</form>
@endsection
