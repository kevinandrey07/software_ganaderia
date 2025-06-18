@extends('layouts.master')

@section('title', 'Visualización de Potreros')

@section('content')
<h1 class="mb-4">Visualización de Potreros</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<button class="btn btn-info mb-3 float-end" data-bs-toggle="modal" data-bs-target="#modalGrafico">
    Ver Gráfico
</button>

<div class="row">
    @foreach($potreros as $potrero)
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ $potrero->name }}
                <button class="btn btn-success btn-sm" onclick="abrirModalAgregar({{ $potrero->id }})">+</button>
            </div>
            <div class="card-body droppable-area" data-paddock-id="{{ $potrero->id }}">
                @foreach($potrero->assignments as $assign)
                <div class="animal-item draggable-item" draggable="true" data-assignment-id="{{ $assign->id }}">
                    {{ $assign->animal->code }} - {{ $assign->animal->name }}
                    <button class="btn btn-sm btn-danger ms-2 btn-eliminar">X</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal agregar animal -->
<div class="modal fade" id="modalAgregar" tabindex="-1">
    <div class="modal-dialog">
        <form id="formAgregar" method="POST" action="{{ route('potreros.asignar') }}" class="modal-content">
            @csrf
            <input type="hidden" name="paddock_id" id="inputPaddockId">
            <input type="hidden" name="start_date" value="{{ now()->toDateString() }}">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Animal al Potrero</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Animal</label>
                    <select name="animal_id" class="form-select" required>
                        @foreach($bovinos as $bovino)
                        <option value="{{ $bovino->id }}">{{ $bovino->code }} - {{ $bovino->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Agregar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal gráfico -->
<div class="modal fade" id="modalGrafico" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gráfico de Animales por Potrero</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <canvas id="graficoPotreros" style="max-width:400px;max-height:400px;margin:auto;display:block;"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
.droppable-area {
    border: 2px dashed #ccc;
    min-height: 80px;
    padding: 5px;
}
.animal-item {
    background: #3498db;
    color: #fff;
    padding: 3px 8px;
    margin-bottom: 5px;
    border-radius: 4px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: grab;
}
.animal-item .btn-eliminar {
    font-size: 14px;
    padding: 2px 6px;
}
</style>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function abrirModalAgregar(paddockId) {
    document.getElementById('inputPaddockId').value = paddockId;
    var modal = new bootstrap.Modal(document.getElementById('modalAgregar'));
    modal.show();
}

// Drag & Drop
document.querySelectorAll('.droppable-area').forEach(area => {
    area.addEventListener('dragover', e => e.preventDefault());
    area.addEventListener('drop', function(e){
        e.preventDefault();
        const assignmentId = e.dataTransfer.getData('text');
        const newPaddockId = this.dataset.paddockId;

        fetch("{{ route('potreros.mover') }}", {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
            body: JSON.stringify({ assignment_id: assignmentId, new_paddock_id: newPaddockId })
        }).then(() => location.reload());
    });
});

document.querySelectorAll('.draggable-item').forEach(item => {
    item.addEventListener('dragstart', function(e){
        e.dataTransfer.setData('text', this.dataset.assignmentId);
    });
});

// Eliminar
document.querySelectorAll('.btn-eliminar').forEach(btn => {
    btn.addEventListener('click', function(){
        const assignmentId = this.closest('.animal-item').dataset.assignmentId;
        if(confirm('¿Eliminar del potrero?')){
            fetch("{{ route('potreros.eliminarAsignacion') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ assignment_id: assignmentId })
            }).then(() => location.reload());
        }
    });
});

// Gráfico
document.getElementById('modalGrafico').addEventListener('shown.bs.modal', function(){
    fetch("{{ route('potreros.grafica') }}")
        .then(res => res.json())
        .then(data => {
            const ctx = document.getElementById('graficoPotreros').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        data: Object.values(data),
                        backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f1c40f']
                    }]
                }
            });
        });
});
</script>
@endsection
