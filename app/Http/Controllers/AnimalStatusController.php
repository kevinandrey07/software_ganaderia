<?php

namespace App\Http\Controllers;

use App\Models\AnimalStatus;
use Illuminate\Http\Request;

class AnimalStatusController extends Controller
{
    public function index()
    {
        $estados = AnimalStatus::all();
        return view('estados.index', compact('estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:animal_statuses,name',
            'description' => 'nullable|string'
        ]);

        AnimalStatus::create($request->all());
        return back()->with('success', 'Estado agregado');
    }

    public function update(Request $request, $id)
    {
        $estado = AnimalStatus::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:animal_statuses,name,' . $id,
            'description' => 'nullable|string'
        ]);

        $estado->update($request->all());
        return back()->with('success', 'Estado actualizado');
    }

    public function destroy($id)
    {
        $estado = AnimalStatus::findOrFail($id);
        $estado->delete();
        return back()->with('success', 'Estado eliminado');
    }
}

