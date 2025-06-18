@extends('layouts.master')

@section('title', 'Agregar Bovino')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Agregar nuevo Bovino</h1>

    <form action="{{ route('bovinos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="code">Código</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="name">Nombre (opcional)</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label for="sex">Sexo</label>
            <select name="sex" class="form-control" required>
                <option value="macho">Macho</option>
                <option value="hembra">Hembra</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="birth_date">Fecha de Nacimiento</label>
            <input type="date" name="birth_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="breed_id">Raza</label>
            <select name="breed_id" class="form-control" required>
                @foreach ($razas as $raza)
                    <option value="{{ $raza->id }}">{{ $raza->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status_id">Estado</label>
            <select name="status_id" class="form-control" required>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id }}">{{ $estado->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection
