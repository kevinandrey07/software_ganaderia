<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Apprentice;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $apprentices = Apprentice::all();
        $tasks = Task::with('apprentice')->get();

        return view('tasks.index', compact('apprentices', 'tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'apprentice_id' => 'required|exists:apprentices,id',
            'description' => 'required|string',
        ]);

        Task::create([
            'apprentice_id' => $request->apprentice_id,
            'description' => $request->description,
            'status' => 'pendiente',
        ]);

        return redirect()->route('tareas.index')->with('success', 'Tarea creada exitosamente');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'apprentice_id' => 'required|exists:apprentices,id',
            'description' => 'required|string',
        ]);

        $task->update($request->all());

        return redirect()->route('tareas.index')->with('success', 'Tarea actualizada exitosamente');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tareas.index')->with('success', 'Tarea eliminada exitosamente');
    }

    public function verify(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:realizada,no realizada',
            'note' => 'required|string',
        ]);

        $task->update([
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return redirect()->route('tareas.index')->with('success', 'Estado de tarea actualizado exitosamente');
    }
}
