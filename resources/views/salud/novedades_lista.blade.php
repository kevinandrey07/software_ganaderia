@extends('layouts.master')

@section('title', 'Lista de Novedades')

@section('content')
<h1 class="mb-4">Lista de Novedades</h1>

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
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Reportado por</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @forelse($novedades as $nov)
        <tr>
            <td>{{ $nov->animal->code }} - {{ $nov->animal->name }}</td>
            <td>{{ ucfirst($nov->type) }}</td>
            <td>{{ $nov->description }}</td>
            <td>{{ $nov->reported_by }}</td>
            <td>{{ $nov->date }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No hay novedades registradas.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Modal gráfico -->
<div class="modal fade" id="modalGrafico" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gráfico de Novedades</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <canvas id="graficoNovedades" style="max-width:400px; max-height:400px; margin:auto; display:block;"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let chart;

    // Carga el gráfico cuando el modal se muestra
    const modalGrafico = document.getElementById('modalGrafico');
    modalGrafico.addEventListener('shown.bs.modal', function () {
        fetch("{{ route('salud.graficaNovedades') }}")
            .then(res => res.json())
            .then(data => {
                const ctx = document.getElementById('graficoNovedades').getContext('2d');
                if (chart) chart.destroy(); // Destruye gráfico previo si existe

                chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            data: Object.values(data),
                            backgroundColor: ['#3498db', '#e74c3c']
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { position: 'top' }
                        }
                    }
                });
            })
            .catch(err => {
                console.error('Error al cargar los datos del gráfico', err);
            });
    });
});
</script>
@endsection

