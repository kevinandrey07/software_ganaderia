@extends('layouts.master')

@section('title', 'Editar Bovino')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Editar Bovino</h1>

    <form action="{{ route('bovinos.update', $bovino->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Código</label>
            <input type="text" name="code" class="form-control" value="{{ $bovino->code }}" readonly>
        </div>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $bovino->name }}">
        </div>

        <div class="mb-3">
            <label>Raza</label>
            <select name="breed_id" class="form-control">
                @foreach($razas as $raza)
                    <option value="{{ $raza->id }}" @if($bovino->breed_id == $raza->id) selected @endif>{{ $raza->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="status_id" class="form-control">
                @foreach($estados as $estado)
                    <option value="{{ $estado->id }}" @if($bovino->status_id == $estado->id) selected @endif>{{ $estado->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@endsection
