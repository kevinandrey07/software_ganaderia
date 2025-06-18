@extends('layouts.master')

@section('title', 'Reportes Producción de Leche')

@section('content')
<h1 class="mb-4">Reportes Producción de Leche</h1>

<!-- BLOQUE DE ESTILOS SOLO PARA PDF -->
@if(app()->runningInConsole())
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #000; padding: 4px; }
    th { background-color: #f2f2f2; }
    h1 { text-align: center; font-size: 16px; }
</style>
@endif

<!-- FORMULARIO DE FILTRO -->
<form method="GET" class="row g-3 mb-3">
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
        <button name="pdf" value="1" class="btn btn-primary">Generar PDF</button>
    </div>
</form>

<!-- TABLA DE RESULTADOS -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Vaca</th>
            <th>Fecha</th>
            <th>Litros</th>
            <th>Notas</th>
        </tr>
    </thead>
    <tbody>
        @forelse($producciones as $prod)
        <tr>
            <td>{{ $prod->animal->code }} - {{ $prod->animal->name }}</td>
            <td>{{ $prod->date }}</td>
            <td>{{ $prod->liters }}</td>
            <td>{{ $prod->notes }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No hay registros para los filtros seleccionados.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@if(!app()->runningInConsole())
<p class="text-muted">Generado el: {{ now()->format('d/m/Y H:i') }}</p>
@endif

@endsection
