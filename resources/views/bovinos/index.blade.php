@extends('layouts.master')

@section('title', 'Lista de Bovinos')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Lista de Bovinos</h1>

    <!-- Botón para gráfico -->
    <button class="btn btn-primary mb-3 float-right" data-bs-toggle="modal" data-bs-target="#modalGrafico">
        Ver Gráfico
    </button>

    <!-- Tabla de bovinos -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Raza</th>
                <th>Sexo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bovinos as $bovino)
                <tr>
                    <td>{{ $bovino->code }}</td>
                    <td>{{ $bovino->name }}</td>
                    <td>{{ $bovino->breed->name }}</td>
                    <td>{{ ucfirst($bovino->sex) }}</td>
                    <td>{{ $bovino->status->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Resumen por estado -->
    <h3 class="mt-4">Resumen por Estado</h3>
    <ul>
        @foreach ($resumen as $item)
            <li>{{ $item->name }}: {{ $item->animals_count }}</li>
        @endforeach
    </ul>

    <!-- Modal del gráfico -->
    <div class="modal fade" id="modalGrafico" tabindex="-1" aria-labelledby="modalGraficoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGraficoLabel">Gráfico de Estados de Bovinos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <canvas id="graficoEstados" style="max-width: 400px; max-height: 400px; margin: auto; display: block;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let chart;
    const modalGrafico = document.getElementById('modalGrafico');

    modalGrafico.addEventListener('shown.bs.modal', function () {
        const ctx = document.getElementById('graficoEstados').getContext('2d');

        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    @foreach ($resumen as $item)
                        "{{ $item->name }}",
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach ($resumen as $item)
                            {{ $item->animals_count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        '#3498db', '#e74c3c', '#2ecc71',
                        '#f1c40f', '#9b59b6', '#e67e22', '#1abc9c'
                    ]
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
                            return label + ': ' + value;
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
});
</script>
@endsection
