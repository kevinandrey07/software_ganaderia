@extends('layouts.master')

@section('title', 'Vacunación')

@section('content')
<h1 class="mb-4">Registrar Vacunación</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('salud.registrarVacuna') }}" method="POST">
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
        <label class="form-label">Nombre de la Vacuna</label>
        <input type="text" name="vaccine_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Motivo</label>
        <input type="text" name="reason" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Aplicado por</label>
        <input type="text" name="applied_by" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Fecha</label>
        <input type="date" name="date" class="form-control" required>
    </div>

    <button class="btn btn-primary">Registrar Vacuna</button>
</form>
@endsection
