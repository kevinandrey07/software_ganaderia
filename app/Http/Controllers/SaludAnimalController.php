<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Incident;
use App\Models\Treatment;
use App\Models\Vaccination;
use App\Models\AnimalLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SaludAnimalController extends Controller
{
    public function index()
    {
        return view('salud.index');
    }

    // VISTA PARA AGREGAR NOVEDAD
    public function novedades()
    {
        $bovinos = Animal::all();
        return view('salud.novedades_create', compact('bovinos'));
    }

    // GUARDAR NOVEDAD
    public function registrarNovedad(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'type' => 'required|in:accidente,enfermedad',
            'description' => 'required',
            'reported_by' => 'required',
            'date' => 'required|date',
        ]);

        $incidente = Incident::create($request->all());

        AnimalLog::create([
            'animal_id' => $request->animal_id,
            'type' => 'novedad',
            'description' => 'Novedad registrada: ' . $request->type,
        ]);

        return back()->with('success', 'Novedad registrada');
    }

    // LISTA DE NOVEDADES + GRAFICO
    public function novedadesLista()
{
    $novedades = Incident::with('animal')->get();
    return view('salud.novedades_lista', compact('novedades'));
}


    // DATOS GRAFICO NOVEDADES
    public function graficaNovedades(Request $request)
    {
        $query = Incident::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        $data = $query->get()
            ->groupBy('type')
            ->map(function($items) {
                return $items->count();
            });

        return response()->json($data);
    }

    // LISTA DE TRATAMIENTOS + GRAFICO
    public function tratamientos()
    {
        $novedades = Incident::with('animal')->get();
        return view('salud.tratamientos', compact('novedades'));
    }

    // GUARDAR TRATAMIENTO
    public function registrarTratamiento(Request $request)
    {
        $request->validate([
            'incident_id' => 'required|exists:incidents,id',
            'description' => 'required',
            'treated_by' => 'required',
            'date' => 'required|date',
        ]);

        $novedad = Incident::findOrFail($request->incident_id);

        Treatment::create($request->all());

        AnimalLog::create([
            'animal_id' => $novedad->animal_id,
            'type' => 'modificación',
            'description' => 'Tratamiento aplicado',
        ]);

        return back()->with('success', 'Tratamiento guardado');
    }

    // DATOS GRAFICO TRATAMIENTOS
    public function graficaTratamientos(Request $request)
    {
        $query = Treatment::with('incident');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        $data = $query->get()
            ->groupBy(function($item) {
                return $item->incident->type;
            })
            ->map(function($items) {
                return $items->count();
            });

        return response()->json($data);
    }
    
    // LISTA DE TRATAMIENTOS

    public function tratamientosLista()
{
    $tratamientos = Treatment::with('incident.animal')->get();
    return view('salud.tratamientos_lista', compact('tratamientos'));
}


    // VACUNACION
    public function vacunacion()
    {
        $bovinos = Animal::all();
        return view('salud.vacunacion', compact('bovinos'));
    }

    public function registrarVacuna(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'vaccine_name' => 'required',
            'reason' => 'nullable|string',
            'applied_by' => 'required',
            'date' => 'required|date',
        ]);

        Vaccination::create($request->all());

        AnimalLog::create([
            'animal_id' => $request->animal_id,
            'type' => 'modificación',
            'description' => 'Vacuna aplicada: ' . $request->vaccine_name,
        ]);

        return back()->with('success', 'Vacuna registrada');
    }
}
