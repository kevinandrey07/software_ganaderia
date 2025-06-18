@extends('layouts.master')

@section('title', 'Gestión de Potreros')

@section('content')
<h1 class="mb-4">Gestión de Potreros</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('potreros.create') }}" class="btn btn-success mb-3">Agregar Potrero</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Ubicación</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($potreros as $potrero)
        <tr>
            <td>{{ $potrero->name }}</td>
            <td>{{ $potrero->location }}</td>
            <td>{{ $potrero->description }}</td>
            <td>
                <!-- Botón Editar -->
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $potrero->id }}">
                    Editar
                </button>

                <!-- Botón Eliminar -->
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $potrero->id }}">
                    Eliminar
                </button>
            </td>
        </tr>

        <!-- Modal Editar -->
        <div class="modal fade" id="modalEditar{{ $potrero->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('potreros.update', $potrero->id) }}" method="POST" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Potrero - {{ $potrero->name }}</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ $potrero->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ubicación</label>
                            <input type="text" name="location" class="form-control" value="{{ $potrero->location }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="form-control">{{ $potrero->description }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Eliminar -->
        <div class="modal fade" id="modalEliminar{{ $potrero->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('potreros.destroy', $potrero->id) }}" method="POST" class="modal-content">
                    @csrf @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Eliminación</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar el potrero <strong>{{ $potrero->name }}</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        @empty
        <tr>
            <td colspan="4" class="text-center">No hay potreros registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
