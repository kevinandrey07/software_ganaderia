<?php
namespace App\Http\Controllers;

use App\Models\Breed;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    public function index()
    {
        $razas = Breed::all();
        return view('razas.index', compact('razas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:breeds,name',
            'description' => 'nullable|string'
        ]);

        Breed::create($request->all());
        return back()->with('success', 'Raza agregada');
    }

    public function update(Request $request, $id)
    {
        $raza = Breed::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:breeds,name,' . $id,
            'description' => 'nullable|string'
        ]);

        $raza->update($request->all());
        return back()->with('success', 'Raza actualizada');
    }

    public function destroy($id)
    {
        $raza = Breed::findOrFail($id);
        $raza->delete();
        return back()->with('success', 'Raza eliminada');
    }
}
