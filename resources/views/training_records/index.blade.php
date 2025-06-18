@extends('layouts.master')
@section('content')
<h1>Fichas</h1>

<!-- Botón para abrir modal de agregar ficha -->
<a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar Ficha</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($trainingRecords as $record)
        <tr>
            <td>{{ $record->code }}</td>
            <td>{{ $record->name }}</td>
            <td>
                <!-- Botón para abrir modal de edición -->
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $record->id }}">Editar</button>

                <!-- Formulario para eliminar -->
                <form action="{{ route('fichas.destroy', $record) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('¿Seguro que desea eliminar esta ficha?')">Eliminar</button>
                </form>
            </td>
        </tr>

        <!-- Modal de edición -->
        <div class="modal fade" id="editModal{{ $record->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('fichas.update', $record) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Ficha</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Código</label>
                                <input type="text" name="code" class="form-control" value="{{ $record->code }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control" value="{{ $record->name }}" required>
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

<!-- Modal de creación -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('fichas.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Ficha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Código</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="name" class="form-control" required>
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
