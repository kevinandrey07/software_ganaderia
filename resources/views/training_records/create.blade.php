@extends('layouts.master')
@section('content')
<h1>Agregar Ficha</h1>
<form action="{{ route('training-records.store') }}" method="POST">
    @csrf
    <div>
        <label>Código</label>
        <input type="text" name="code" required>
    </div>
    <div>
        <label>Nombre</label>
        <input type="text" name="name" required>
    </div>
    <button class="btn btn-success">Guardar</button>
</form>
@endsection
