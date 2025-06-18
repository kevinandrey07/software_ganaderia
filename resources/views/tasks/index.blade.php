@extends('layouts.master')
@section('content')
<h1>Tareas</h1>

<!-- Botón para abrir modal de agregar tarea -->
<a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar Tarea</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Aprendiz</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Nota</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->apprentice->name }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ ucfirst($task->status) }}</td>
            <td>{{ $task->note }}</td>
            <td>
                <!-- BOTÓN EDITAR -->
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $task->id }}">Editar</button>

                <!-- BOTÓN ELIMINAR -->
                <form action="{{ route('tareas.destroy', $task) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('¿Seguro que desea eliminar esta tarea?')">Eliminar</button>
                </form>

                <!-- BOTÓN VERIFICAR -->
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $task->id }}">Verificar</button>
            </td>
        </tr>

        <!-- MODAL EDITAR -->
        <div class="modal fade" id="editModal{{ $task->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('tareas.update', $task) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Tarea</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Aprendiz</label>
                                <select name="apprentice_id" class="form-control" required>
                                    @foreach($apprentices as $apprentice)
                                    <option value="{{ $apprentice->id }}" @if($task->apprentice_id == $apprentice->id) selected @endif>{{ $apprentice->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Descripción</label>
                                <textarea name="description" class="form-control" required>{{ $task->description }}</textarea>
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

        <!-- MODAL VERIFICAR -->
        <div class="modal fade" id="verifyModal{{ $task->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('tareas.verify', $task) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Verificar Tarea</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Estado</label>
                                <select name="status" class="form-control" required>
                                    <option value="realizada">Realizada</option>
                                    <option value="no realizada">No Realizada</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Nota</label>
                                <textarea name="note" class="form-control" required>{{ $task->note }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Confirmar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </tbody>
</table>

<!-- MODAL CREAR -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tareas.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Aprendiz</label>
                        <select name="apprentice_id" class="form-control" required>
                            @foreach($apprentices as $apprentice)
                            <option value="{{ $apprentice->id }}">{{ $apprentice->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea name="description" class="form-control" required></textarea>
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
