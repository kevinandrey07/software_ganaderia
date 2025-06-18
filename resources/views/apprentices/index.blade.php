@extends('layouts.master')
@section('content')
<h1>Aprendices</h1>

<a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar Aprendiz</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Fecha Nacimiento</th>
            <th>Género</th>
            <th>Ficha</th>
            <th>Etapa</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($apprentices as $apprentice)
        <tr>
            <td>{{ $apprentice->name }}</td>
            <td>{{ $apprentice->birth_date }}</td>
            <td>{{ $apprentice->gender }}</td>
            <td>{{ $apprentice->trainingRecord->name }}</td>
            <td>{{ ucfirst($apprentice->stage) }}</td>
            <td>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $apprentice->id }}">Editar</button>
                <form action="{{ route('aprendices.destroy', $apprentice) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('¿Seguro que desea eliminar este aprendiz?')">Eliminar</button>
                </form>
            </td>
        </tr>

        <div class="modal fade" id="editModal{{ $apprentice->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('aprendices.update', $apprentice) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Aprendiz</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control" value="{{ $apprentice->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Fecha Nacimiento</label>
                                <input type="date" name="birth_date" class="form-control" value="{{ $apprentice->birth_date }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Género</label>
                                <select name="gender" class="form-control" required>
                                    <option value="M" @if($apprentice->gender == 'M') selected @endif>M</option>
                                    <option value="F" @if($apprentice->gender == 'F') selected @endif>F</option>
                                    <option value="O" @if($apprentice->gender == 'O') selected @endif>O</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Ficha</label>
                                <select name="training_record_id" class="form-control" required>
                                    @foreach($trainingRecords as $record)
                                    <option value="{{ $record->id }}" @if($apprentice->training_record_id == $record->id) selected @endif>{{ $record->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Etapa</label>
                                <select name="stage" class="form-control" required>
                                    <option value="lectiva" @if($apprentice->stage == 'lectiva') selected @endif>Lectiva</option>
                                    <option value="productiva" @if($apprentice->stage == 'productiva') selected @endif>Productiva</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success">Actualizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('aprendices.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Aprendiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Fecha Nacimiento</label>
                        <input type="date" name="birth_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Género</label>
                        <select name="gender" class="form-control" required>
                            <option value="M">M</option>
                            <option value="F">F</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Ficha</label>
                        <select name="training_record_id" class="form-control" required>
                            @foreach($trainingRecords as $record)
                            <option value="{{ $record->id }}">{{ $record->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Etapa</label>
                        <select name="stage" class="form-control" required>
                            <option value="lectiva">Lectiva</option>
                            <option value="productiva">Productiva</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
