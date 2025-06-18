@extends('layouts.master')

@section('title', 'Historial Bovino')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Historial Bovino</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bovinos as $bovino)
                <tr>
                    <td>{{ $bovino->code }}</td>
                    <td>{{ $bovino->name }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistorial{{ $bovino->id }}">
                            Ver Historial
                        </button>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="modalHistorial{{ $bovino->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Historial de {{ $bovino->code }} - {{ $bovino->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="accordion" id="accordionHistorial{{ $bovino->id }}">
                                    <!-- Cambios -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cambios{{ $bovino->id }}">
                                                Cambios / Seguimientos
                                            </button>
                                        </h2>
                                        <div id="cambios{{ $bovino->id }}" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <ul>
                                                    @forelse ($bovino->logs as $log)
                                                        <li>{{ optional($log->created_at)->format('d/m/Y H:i') }} - {{ $log->type }}: {{ $log->description }}</li>
                                                    @empty
                                                        <li>No hay seguimientos registrados.</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dietas -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dietas{{ $bovino->id }}">
                                                Dietas
                                            </button>
                                        </h2>
                                        <div id="dietas{{ $bovino->id }}" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <ul>
                                                    @forelse ($bovino->diets as $d)
                                                        <li>
                                                            {{ $d->pivot->start_date ? \Carbon\Carbon::parse($d->pivot->start_date)->format('d/m/Y') : 'Sin fecha' }} -
                                                            {{ $d->name }}
                                                            ({{ $d->pivot->notes ?? 'Sin notas' }})
                                                        </li>
                                                    @empty
                                                        <li>No hay dietas registradas.</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Incidentes + Tratamientos -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#incidentes{{ $bovino->id }}">
                                                Incidentes y Tratamientos
                                            </button>
                                        </h2>
                                        <div id="incidentes{{ $bovino->id }}" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <ul>
                                                    @forelse ($bovino->incidents as $inc)
                                                        <li>
                                                            <strong>{{ $inc->date }} - {{ ucfirst($inc->type) }}:</strong> {{ $inc->description }}
                                                            <ul>
                                                                @forelse ($inc->treatments as $trat)
                                                                    <li>{{ $trat->date }} - {{ $trat->description }} ({{ $trat->treated_by }})</li>
                                                                @empty
                                                                    <li>Sin tratamientos registrados.</li>
                                                                @endforelse
                                                            </ul>
                                                        </li>
                                                    @empty
                                                        <li>No hay incidentes registrados.</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vacunaciones -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#vacunas{{ $bovino->id }}">
                                                Vacunaciones
                                            </button>
                                        </h2>
                                        <div id="vacunas{{ $bovino->id }}" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <ul>
                                                    @forelse ($bovino->vaccinations as $vac)
                                                        <li>{{ $vac->date }} - {{ $vac->vaccine_name }} ({{ $vac->reason }})</li>
                                                    @empty
                                                        <li>No hay vacunaciones registradas.</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Potreros -->
                                    <div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#potreros{{ $bovino->id }}">
            Movimientos en Potreros
        </button>
    </h2>
    <div id="potreros{{ $bovino->id }}" class="accordion-collapse collapse">
        <div class="accordion-body">
            <ul>
                @forelse ($bovino->paddockAssignments as $mov)
                    <li>
                        <strong>{{ $mov->paddock->name }}</strong> — 
                        Inicio: {{ \Carbon\Carbon::parse($mov->start_date)->format('d/m/Y H:i') }},
                        Fin: {{ $mov->end_date ? \Carbon\Carbon::parse($mov->end_date)->format('d/m/Y H:i') : 'Actual' }},
                        Movido por: {{ $mov->moved_by }}
                    </li>
                @empty
                    <li>No hay movimientos registrados.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

                                    <!-- Leche -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#leche{{ $bovino->id }}">
                                                Producción de Leche
                                            </button>
                                        </h2>
                                        <div id="leche{{ $bovino->id }}" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <ul>
                                                    @forelse ($bovino->milkProductions as $milk)
                                                        <li>{{ $milk->date }} - {{ $milk->liters }} litros</li>
                                                    @empty
                                                        <li>No hay producción registrada.</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /accordion -->
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
@endsection
