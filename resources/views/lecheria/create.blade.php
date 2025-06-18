@extends('layouts.master')

@section('title', 'Agregar Producción de Leche')

@section('content')
<h1 class="mb-4">Agregar Producción de Leche</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('lecheria.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="animal_id" class="form-label">Vaca en Lactancia</label>
        <select name="animal_id" id="animal_id" class="form-select" required>
            <option value="">Seleccione una vaca</option>
            @foreach($vacas as $vaca)
            <option value="{{ $vaca->id }}">{{ $vaca->code }} - {{ $vaca->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Fecha</label>
        <input type="date" name="date" id="date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="liters" class="form-label">Litros</label>
        <input type="number" step="0.01" name="liters" id="liters" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="notes" class="form-label">Notas</label>
        <textarea name="notes" id="notes" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection
