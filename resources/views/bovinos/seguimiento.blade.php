@extends('layouts.master')

@section('title', 'Seguimiento Bovino')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Seguimiento Bovino</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Raza</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bovinos as $bovino)
                <tr>
                    <td>{{ $bovino->code }}</td>
                    <td>{{ $bovino->name }}</td>
                    <td>{{ $bovino->breed->name }}</td>
                    <td>{{ $bovino->status->name }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalSeguimiento{{ $bovino->id }}">
                            Editar Seguimiento
                        </button>
                    </td>
                </tr>

                <!-- Modal seguimiento -->
                <div class="modal fade" id="modalSeguimiento{{ $bovino->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('bovinos.updateSeguimiento', $bovino->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Seguimiento de {{ $bovino->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label>Nuevo Estado</label>
                                    <select name="status_id" class="form-control" required>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado->id }}" {{ $bovino->status_id == $estado->id ? 'selected' : '' }}>
                                                {{ $estado->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label>Nueva Raza</label>
                                    <select name="breed_id" class="form-control" required>
                                        @foreach ($razas as $raza)
                                            <option value="{{ $raza->id }}" {{ $bovino->breed_id == $raza->id ? 'selected' : '' }}>
                                                {{ $raza->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label>Notas de seguimiento</label>
                                    <textarea name="log_description" class="form-control"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
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
