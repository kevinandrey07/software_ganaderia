<?php

namespace App\Http\Controllers;

use App\Models\Paddock;
use App\Models\Animal;
use App\Models\PaddockAssignment;
use App\Models\AnimalLog;
use Illuminate\Http\Request;

class PotreroController extends Controller
{
    public function index()
    {
        $potreros = Paddock::all();
        return view('potreros.index', compact('potreros'));
    }

    public function create()
    {
        return view('potreros.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:paddocks',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Paddock::create($request->all());

        return redirect()->route('potreros.index')->with('success', 'Potrero agregado');
    }

    public function edit($id)
    {
        $potrero = Paddock::findOrFail($id);
        return view('potreros.edit', compact('potrero'));
    }

    public function update(Request $request, $id)
    {
        $potrero = Paddock::findOrFail($id);
        $potrero->update($request->all());

        return redirect()->route('potreros.index')->with('success', 'Potrero actualizado');
    }

    public function destroy($id)
    {
        Paddock::findOrFail($id)->delete();
        return back()->with('success', 'Potrero eliminado');
    }

    public function visualizar()
    {
        $potreros = Paddock::with(['assignments' => function($q){
            $q->whereNull('end_date')->with('animal');
        }])->get();
        $bovinos = Animal::all();
        return view('potreros.visualizar', compact('potreros', 'bovinos'));
    }

    public function asignarAnimal(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'paddock_id' => 'required|exists:paddocks,id',
            'start_date' => 'required|date',
        ]);

        // Cierra asignaciones previas
        PaddockAssignment::where('animal_id', $request->animal_id)
            ->whereNull('end_date')
            ->update(['end_date' => now()]);

        // Nueva asignación
        PaddockAssignment::create([
            'animal_id' => $request->animal_id,
            'paddock_id' => $request->paddock_id,
            'start_date' => $request->start_date,
            'moved_by' => auth()->user()->name ?? 'sistema'
        ]);

        AnimalLog::create([
            'animal_id' => $request->animal_id,
            'type' => 'movimiento',
            'description' => 'Animal asignado al potrero ID: ' . $request->paddock_id,
        ]);

        return response()->json(['success' => true]);
    }

    public function moverAnimal(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:paddock_assignments,id',
            'new_paddock_id' => 'required|exists:paddocks,id',
        ]);

        $old = PaddockAssignment::findOrFail($request->assignment_id);
        $old->update(['end_date' => now()]);

        $new = PaddockAssignment::create([
            'animal_id' => $old->animal_id,
            'paddock_id' => $request->new_paddock_id,
            'start_date' => now(),
            'moved_by' => auth()->user()->name ?? 'sistema'
        ]);

        AnimalLog::create([
            'animal_id' => $old->animal_id,
            'type' => 'movimiento',
            'description' => 'Animal movido al potrero ID: ' . $request->new_paddock_id,
        ]);

        return response()->json(['success' => true]);
    }

    public function moverTodos(Request $request)
    {
        $request->validate([
            'from_paddock_id' => 'required|exists:paddocks,id',
            'to_paddock_id' => 'required|exists:paddocks,id',
        ]);

        $asignaciones = PaddockAssignment::where('paddock_id', $request->from_paddock_id)
            ->whereNull('end_date')->get();

        foreach ($asignaciones as $asignacion) {
            $asignacion->update(['end_date' => now()]);

            PaddockAssignment::create([
                'animal_id' => $asignacion->animal_id,
                'paddock_id' => $request->to_paddock_id,
                'start_date' => now(),
                'moved_by' => auth()->user()->name ?? 'sistema'
            ]);

            AnimalLog::create([
                'animal_id' => $asignacion->animal_id,
                'type' => 'movimiento',
                'description' => 'Animal movido en lote al potrero ID: ' . $request->to_paddock_id,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function eliminarAsignacion(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:paddock_assignments,id',
        ]);

        $asignacion = PaddockAssignment::findOrFail($request->assignment_id);
        $asignacion->update(['end_date' => now()]);

        AnimalLog::create([
            'animal_id' => $asignacion->animal_id,
            'type' => 'movimiento',
            'description' => 'Animal eliminado del potrero',
        ]);

        return response()->json(['success' => true]);
    }

    public function grafica()
    {
        $data = Paddock::withCount(['assignments' => function($q){
            $q->whereNull('end_date');
        }])->get()->pluck('assignments_count', 'name');
        return response()->json($data);
    }
}