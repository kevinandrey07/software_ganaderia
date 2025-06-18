@extends('layouts.master')

@section('title', 'Lista de Producción de Leche')

@section('content')
<h1 class="mb-4">Producción de Leche</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Filtros -->
<form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
        <label class="form-label">Desde</label>
        <input type="date" name="from" value="{{ request('from') }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">Hasta</label>
        <input type="date" name="to" value="{{ request('to') }}" class="form-control">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-secondary">Filtrar</button>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalGrafico">
            Ver Gráfico
        </button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Vaca</th>
            <th>Fecha</th>
            <th>Litros</th>
            <th>Notas</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($producciones as $prod)
        <tr>
            <td>{{ $prod->animal->code }} - {{ $prod->animal->name }}</td>
            <td>{{ $prod->date }}</td>
            <td>{{ $prod->liters }}</td>
            <td>{{ $prod->notes }}</td>
            <td>
                <!-- Botón Editar -->
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $prod->id }}">
                    Editar
                </button>

                <!-- Botón Eliminar -->
                <form action="{{ route('lecheria.destroy', $prod->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar producción?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>

        <!-- MODAL EDITAR -->
        <div class="modal fade" id="modalEditar{{ $prod->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('lecheria.update', $prod->id) }}" method="POST" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Producción - {{ $prod->animal->code }} {{ $prod->animal->name }}</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="date" value="{{ $prod->date }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Litros</label>
                            <input type="number" step="0.01" name="liters" value="{{ $prod->liters }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notas</label>
                            <textarea name="notes" class="form-control">{{ $prod->notes }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        @endforeach
    </tbody>
</table>

<!-- Modal gráfico -->
<div class="modal fade" id="modalGrafico" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gráfico de Producción de Leche</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <canvas id="graficoLeche" style="max-width: 400px; max-height: 400px; margin: auto; display: block;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let chart;
    const modal = document.getElementById('modalGrafico');

    modal.addEventListener('shown.bs.modal', function() {
        const ctx = document.getElementById('graficoLeche').getContext('2d');

        if (chart) chart.destroy();

        fetch("{{ route('lecheria.grafica') }}?from={{ request('from') }}&to={{ request('to') }}")
            .then(res => res.json())
            .then(data => {
                chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            data: Object.values(data),
                            backgroundColor: ['#f1c40f', '#3498db', '#2ecc71', '#e67e22', '#9b59b6', '#1abc9c']
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { display: false },
                            datalabels: {
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                },
                                formatter: function(value, context) {
                                    let label = context.chart.data.labels[context.dataIndex];
                                    return label + ': ' + value + ' L';
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            })
            .catch(err => console.error('Error cargando gráfico', err));
    });
});
</script>
@endsection
