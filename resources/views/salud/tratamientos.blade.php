@extends('layouts.master')

@section('title', 'Tratamientos')

@section('content')
<h1 class="mb-4">Tratamientos</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalGrafico">
        Ver Gráfico
    </button>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Bovino</th>
            <th>Novedad</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($novedades as $nov)
        <tr>
            <td>{{ $nov->animal->code }} - {{ $nov->animal->name }}</td>
            <td>{{ ucfirst($nov->type) }} - {{ $nov->description }}</td>
            <td>
                <form action="{{ route('salud.registrarTratamiento') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="incident_id" value="{{ $nov->id }}">
                    <input type="text" name="description" class="form-control mb-1" placeholder="Descripción" required>
                    <input type="text" name="treated_by" class="form-control mb-1" placeholder="Tratado por" required>
                    <input type="date" name="date" class="form-control mb-1" required>
                    <button class="btn btn-sm btn-primary">Agregar Tratamiento</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">No hay novedades para tratamiento.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Modal gráfico -->
<div class="modal fade" id="modalGrafico" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gráfico de Tratamientos</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <canvas id="graficoTratamientos"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch("{{ route('salud.graficaTratamientos') }}")
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('graficoTratamientos'), {
                type: 'pie',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        data: Object.values(data),
                        backgroundColor: ['#2ecc71', '#f39c12']
                    }]
                }
            });
        });
});
</script>
@endsection
