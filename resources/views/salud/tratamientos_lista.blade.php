@extends('layouts.master')

@section('title', 'Lista de Tratamientos')

@section('content')
<h1 class="mb-4">Lista de Tratamientos</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Bovino</th>
            <th>Tipo de Novedad</th>
            <th>Descripción de Novedad</th>
            <th>Descripción del Tratamiento</th>
            <th>Tratado por</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tratamientos as $trat)
        <tr>
            <td>{{ $trat->incident->animal->code }} - {{ $trat->incident->animal->name }}</td>
            <td>{{ ucfirst($trat->incident->type) }}</td>
            <td>{{ $trat->incident->description }}</td>
            <td>{{ $trat->description }}</td>
            <td>{{ $trat->treated_by }}</td>
            <td>{{ $trat->date }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No hay tratamientos registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
