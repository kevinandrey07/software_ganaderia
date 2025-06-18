@extends('layouts.master')
@section('content')
<h1>Agregar Aprendiz</h1>
<form action="{{ route('apprentices.store') }}" method="POST">
    @csrf
    <div>
        <label>Nombre</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Fecha de Nacimiento</label>
        <input type="date" name="birth_date" required>
    </div>
    <div>
        <label>Género</label>
        <select name="gender" required>
            <option value="M">M</option>
            <option value="F">F</option>
            <option value="O">O</option>
        </select>
    </div>
    <div>
        <label>Ficha</label>
        <select name="training_record_id" required>
            @foreach($trainingRecords as $record)
            <option value="{{ $record->id }}">{{ $record->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Etapa</label>
        <select name="stage" required>
            <option value="lectiva">Lectiva</option>
            <option value="productiva">Productiva</option>
        </select>
    </div>
    <button class="btn btn-success">Guardar</button>
</form>
@endsection
