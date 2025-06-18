<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\MilkProduction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LecheriaController extends Controller
{
    // Formulario agregar leche
    public function create()
    {
        $vacas = Animal::whereHas('status', function($q) {
            $q->where('name', 'lactancia');
        })->get();

        return view('lecheria.create', compact('vacas'));
    }

    // Guardar producción
    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'date' => 'required|date',
            'liters' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        MilkProduction::create($request->all());

        return redirect()->route('lecheria.index')->with('success', 'Producción de leche registrada.');
    }

    // Visualizar producción con filtros
    public function index(Request $request)
    {
        $query = MilkProduction::with('animal');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        $producciones = $query->orderBy('date', 'desc')->get();

        return view('lecheria.index', compact('producciones'));
    }

    // Editar producción
    public function edit($id)
    {
        $produccion = MilkProduction::findOrFail($id);
        return view('lecheria.edit', compact('produccion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'liters' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $produccion = MilkProduction::findOrFail($id);
        $produccion->update($request->all());

        return redirect()->route('lecheria.index')->with('success', 'Producción actualizada.');
    }

    // Eliminar producción
    public function destroy($id)
    {
        $produccion = MilkProduction::findOrFail($id);
        $produccion->delete();

        return redirect()->route('lecheria.index')->with('success', 'Producción eliminada.');
    }

    // Reportes con filtros
    public function reportes(Request $request)
    {
        $query = MilkProduction::with('animal');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        $producciones = $query->orderBy('date')->get();

        if ($request->has('pdf')) {
            // Renderiza la vista exclusiva para el PDF
            $pdf = Pdf::loadView('lecheria.pdf', compact('producciones'));
            return $pdf->download('reporte_lecheria.pdf');
        }

        return view('lecheria.reportes', compact('producciones'));
    }

    // Datos para gráfico
    public function grafica(Request $request)
    {
        $query = MilkProduction::with('animal');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        $data = $query->get()
            ->groupBy('animal.name')
            ->map(function ($items) {
                return $items->sum('liters');
            });

        return response()->json($data);
    }
}
