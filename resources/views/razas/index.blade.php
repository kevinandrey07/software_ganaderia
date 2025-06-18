@extends('layouts.master')

@section('title', 'Gestión de Razas')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Gestión de Razas</h1>

    <!-- Formulario para agregar raza -->
    <form action="{{ route('razas.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="mb-2">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Descripción</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Agregar</button>
    </form>

    <!-- Lista de razas -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($razas as $raza)
                <tr>
                    <td>{{ $raza->name }}</td>
                    <td>{{ $raza->description }}</td>
                    <td>
                        <!-- Botón Editar -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $raza->id }}">Editar</button>

                        <!-- Botón Eliminar -->
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $raza->id }}">Eliminar</button>
                    </td>
                </tr>

                <!-- Modal Editar -->
                <div class="modal fade" id="modalEditar{{ $raza->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('razas.update', $raza->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Raza</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label>Nombre</label>
                                    <input type="text" name="name" value="{{ $raza->name }}" class="form-control" required>
                                    <label>Descripción</label>
                                    <textarea name="description" class="form-control">{{ $raza->description }}</textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Eliminar -->
                <div class="modal fade" id="modalEliminar{{ $raza->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('razas.destroy', $raza->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Eliminar Raza</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de eliminar la raza <strong>{{ $raza->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            @endforeach
        </tbody>
    </table>
@endsection
