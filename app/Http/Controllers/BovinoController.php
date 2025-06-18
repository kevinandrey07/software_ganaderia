<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\AnimalStatus;
use App\Models\AnimalLog;
use App\Models\AnimalDiet;
use App\Models\Diet;
use Illuminate\Http\Request;

class BovinoController extends Controller
{
    // =============================
    // LISTA DE BOVINOS
    // =============================
    public function index()
    {
        $bovinos = Animal::with('breed', 'status')->get();
        $resumen = AnimalStatus::withCount(['animals'])->get();

        return view('bovinos.index', compact('bovinos', 'resumen'));
    }

    // =============================
    // CREAR BOVINO
    // =============================
    public function create()
    {
        $razas = Breed::all();
        $estados = AnimalStatus::all();
        return view('bovinos.create', compact('razas', 'estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:animals,code',
            'sex' => 'required|in:macho,hembra',
            'birth_date' => 'required|date',
            'breed_id' => 'required|exists:breeds,id',
            'status_id' => 'required|exists:animal_statuses,id',
        ]);

        $bovino = Animal::create($request->all());

        AnimalLog::create([
            'animal_id' => $bovino->id,
            'type' => 'modificación',
            'description' => 'Bovino registrado',
        ]);

        return redirect()->route('bovinos.index')->with('success', 'Bovino agregado correctamente.');
    }

    // =============================
    // EDITAR / ACTUALIZAR BOVINO
    // =============================
    public function edit($id)
    {
        $bovino = Animal::findOrFail($id);
        $razas = Breed::all();
        $estados = AnimalStatus::all();
        return view('bovinos.edit', compact('bovino', 'razas', 'estados'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sex' => 'required|in:macho,hembra',
            'birth_date' => 'required|date',
            'breed_id' => 'required|exists:breeds,id',
            'status_id' => 'required|exists:animal_statuses,id',
        ]);

        $bovino = Animal::findOrFail($id);
        $bovino->update($request->all());

        AnimalLog::create([
            'animal_id' => $bovino->id,
            'type' => 'modificación',
            'description' => 'Datos actualizados',
        ]);

        return redirect()->route('bovinos.index')->with('success', 'Bovino actualizado.');
    }

    // =============================
    // ELIMINAR BOVINO
    // =============================
    public function destroy($id)
    {
        $bovino = Animal::findOrFail($id);
        $bovino->delete();

        return redirect()->route('bovinos.index')->with('success', 'Bovino eliminado.');
    }

    // =============================
    // NUTRICIÓN BOVINA
    // =============================
    public function nutricion()
    {
        $bovinos = Animal::with('breed', 'status')->get();
        $dietas = Diet::all();
        return view('bovinos.nutricion', compact('bovinos', 'dietas'));
    }

    public function guardarNutricion(Request $request, $id)
{
    $request->validate([
        'diet_name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'notes' => 'nullable|string'
    ]);

    // Busca la dieta o la crea si no existe
    $dieta = Diet::firstOrCreate(
        ['name' => $request->diet_name],
        ['description' => 'Dieta agregada desde nutrición bovina']
    );

    AnimalDiet::create([
        'animal_id' => $id,
        'diet_id' => $dieta->id,
        'start_date' => $request->start_date,
        'end_date' => null,
        'notes' => $request->notes
    ]);

    AnimalLog::create([
        'animal_id' => $id,
        'type' => 'dieta',
        'description' => 'Nueva dieta asignada: ' . $dieta->name,
    ]);

    return back()->with('success', 'Dieta asignada correctamente.');
}


    // =============================
    // SEGUIMIENTO BOVINO
    // =============================
    public function seguimiento()
    {
        $bovinos = Animal::with('breed', 'status')->get();
        $razas = Breed::all();
        $estados = AnimalStatus::all();
        return view('bovinos.seguimiento', compact('bovinos', 'razas', 'estados'));
    }

    public function updateSeguimiento(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|exists:animal_statuses,id',
            'breed_id' => 'required|exists:breeds,id',
            'log_description' => 'nullable|string'
        ]);

        $bovino = Animal::findOrFail($id);

        $bovino->update([
            'status_id' => $request->status_id,
            'breed_id' => $request->breed_id,
        ]);

        AnimalLog::create([
            'animal_id' => $bovino->id,
            'type' => 'modificación',
            'description' => $request->log_description ?? 'Seguimiento actualizado',
        ]);

        return back()->with('success', 'Seguimiento actualizado correctamente.');
    }

    // =============================
    // HISTORIAL BOVINO
    // =============================
   public function historial()
{
    $bovinos = Animal::with([
        'logs',
        'milkProductions',
        'incidents.treatments', // 🚀 Traemos los tratamientos de los incidentes
        'vaccinations',
        'paddockAssignments',
        'diets'
    ])->get();

    return view('bovinos.historial', compact('bovinos'));
}
}
