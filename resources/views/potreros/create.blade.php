@extends('layouts.master')

@section('title', 'Agregar Potrero')

@section('content')
<h1 class="mb-4">Agregar Potrero</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('potreros.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Ubicación</label>
        <input type="text" name="location" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button class="btn btn-primary">Agregar</button>
</form>
@endsection
