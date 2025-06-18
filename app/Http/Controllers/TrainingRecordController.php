<?php

namespace App\Http\Controllers;

use App\Models\TrainingRecord;
use Illuminate\Http\Request;

class TrainingRecordController extends Controller
{
    public function index()
    {
        $trainingRecords = TrainingRecord::all();
        return view('training_records.index', compact('trainingRecords'));
    }

    public function create()
    {
        return view('training_records.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'code' => 'required|unique:training_records,code',
        'name' => 'required|string|max:255',
    ]);

    TrainingRecord::create($request->all());

    return redirect()->route('fichas.index')->with('success', 'Ficha creada exitosamente');
}

    public function show(TrainingRecord $trainingRecord)
    {
        return view('training_records.show', compact('trainingRecord'));
    }

    public function edit(TrainingRecord $trainingRecord)
    {
        return view('training_records.edit', compact('trainingRecord'));
    }

    public function update(Request $request, TrainingRecord $trainingRecord)
    {
        $request->validate([
            'code' => 'required|unique:training_records,code,' . $trainingRecord->id,
            'name' => 'required|string|max:255',
        ]);

        $trainingRecord->update($request->all());

        return redirect()->route('fichas.index')->with('success', 'Ficha actualizada exitosamente');
    }

    public function destroy(TrainingRecord $trainingRecord)
    {
        $trainingRecord->delete();

        return redirect()->route('fichas.index')->with('success', 'Ficha eliminada exitosamente');
    }
}
