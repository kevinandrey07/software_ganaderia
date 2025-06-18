@extends('layouts.master')

@section('title', 'Nutrición Bovina')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Nutrición Bovina</h1>

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
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalNutricion{{ $bovino->id }}">
                            Agregar Dieta
                        </button>
                    </td>
                </tr>

                <!-- Modal agregar dieta -->
                <div class="modal fade" id="modalNutricion{{ $bovino->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('bovinos.guardarNutricion', $bovino->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Agregar Dieta a {{ $bovino->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label>Dieta</label>
                                    <input type="text" name="diet_name" class="form-control" placeholder="Nombre de la dieta" required>
                                        @foreach ($dietas as $dieta)
                                            <option value="{{ $dieta->id }}">{{ $dieta->name }}</option>
                                        @endforeach
                                </input>

                                    <label>Fecha de Inicio</label>
                                    <input type="date" name="start_date" class="form-control" required>

                                    <label>Notas</label>
                                    <textarea name="notes" class="form-control"></textarea>
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
