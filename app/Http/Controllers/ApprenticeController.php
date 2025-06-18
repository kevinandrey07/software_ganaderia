<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use App\Models\TrainingRecord;
use Illuminate\Http\Request;

class ApprenticeController extends Controller
{
    public function index()
    {
        $apprentices = Apprentice::with('trainingRecord')->get();
        $trainingRecords = TrainingRecord::all();

        return view('apprentices.index', compact('apprentices', 'trainingRecords'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F,O',
            'training_record_id' => 'required|exists:training_records,id',
            'stage' => 'required|in:lectiva,productiva',
        ]);

        Apprentice::create($request->all());

        return redirect()->route('aprendices.index')->with('success', 'Aprendiz creado exitosamente');
    }

    public function update(Request $request, Apprentice $apprentice)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F,O',
            'training_record_id' => 'required|exists:training_records,id',
            'stage' => 'required|in:lectiva,productiva',
        ]);

        $apprentice->update($request->all());

        return redirect()->route('aprendices.index')->with('success', 'Aprendiz actualizado exitosamente');
    }

    public function destroy(Apprentice $apprentice)
    {
        $apprentice->delete();

        return redirect()->route('aprendices.index')->with('success', 'Aprendiz eliminado exitosamente');
    }
}
