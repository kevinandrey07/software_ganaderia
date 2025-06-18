<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\AnimalStatusController;
use App\Http\Controllers\BovinoController;
use App\Http\Controllers\LecheriaController;
use App\Http\Controllers\SaludAnimalController;
use App\Http\Controllers\PotreroController;
use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\TrainingRecordController;
use App\Http\Controllers\TaskController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación protegidas por el middleware centralizado
Auth::routes(['middleware' => 'role.redirect']);

// Rutas protegidas por roles
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:pasante'])->group(function () {
    Route::get('/pasante', function () {
        return view('pasante.dashboard');
    })->name('pasante.dashboard');
});

Route::middleware(['auth', 'role:aprendiz'])->group(function () {
    Route::get('/aprendiz', function () {
        return view('aprendiz.dashboard');
    })->name('aprendiz.dashboard');
});

// 🟢 MÓDULOS GANADEROS (protegidos con auth)
Route::middleware('auth')->group(function () {

    // 🐄 MÓDULO RAZAS
    Route::prefix('razas')->name('razas.')->group(function () {
        Route::get('/', [BreedController::class, 'index'])->name('index');
        Route::post('/', [BreedController::class, 'store'])->name('store');
        Route::put('/{id}', [BreedController::class, 'update'])->name('update');
        Route::delete('/{id}', [BreedController::class, 'destroy'])->name('destroy');
    });

    // 🐄 MÓDULO ESTADOS
    Route::prefix('estados')->name('estados.')->group(function () {
        Route::get('/', [AnimalStatusController::class, 'index'])->name('index');
        Route::post('/', [AnimalStatusController::class, 'store'])->name('store');
        Route::put('/{id}', [AnimalStatusController::class, 'update'])->name('update');
        Route::delete('/{id}', [AnimalStatusController::class, 'destroy'])->name('destroy');
    });

    // 🐄 MÓDULO BOVINOS
    Route::prefix('bovinos')->name('bovinos.')->group(function () {
        Route::get('/', [BovinoController::class, 'index'])->name('index');
        Route::get('/crear', [BovinoController::class, 'create'])->name('create');
        Route::post('/', [BovinoController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [BovinoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BovinoController::class, 'update'])->name('update');
        Route::delete('/{id}', [BovinoController::class, 'destroy'])->name('destroy');

        Route::get('/nutricion', [BovinoController::class, 'nutricion'])->name('nutricion');
        Route::post('/{id}/nutricion', [BovinoController::class, 'guardarNutricion'])->name('guardarNutricion');

        Route::get('/seguimiento', [BovinoController::class, 'seguimiento'])->name('seguimiento');
        Route::put('/{id}/seguimiento', [BovinoController::class, 'updateSeguimiento'])->name('updateSeguimiento');

        Route::get('/historial', [BovinoController::class, 'historial'])->name('historial');
    });


    // 🥛 MÓDULO LECHERÍA
    Route::prefix('lecheria')->name('lecheria.')->group(function () {
        Route::get('/', [LecheriaController::class, 'index'])->name('index');
        Route::get('/crear', [LecheriaController::class, 'create'])->name('create');
        Route::post('/', [LecheriaController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [LecheriaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [LecheriaController::class, 'update'])->name('update');
        Route::delete('/{id}', [LecheriaController::class, 'destroy'])->name('destroy');
        Route::get('/reportes', [LecheriaController::class, 'reportes'])->name('reportes');
        Route::get('/grafica', [LecheriaController::class, 'grafica'])->name('grafica');
    });

    // 🧬 MÓDULO SALUD ANIMAL
    Route::prefix('salud')->name('salud.')->group(function () {
        Route::get('/', [SaludAnimalController::class, 'index'])->name('index');

        // Novedades
        Route::get('/novedades', [SaludAnimalController::class, 'novedades'])->name('novedades');
        Route::post('/novedades', [SaludAnimalController::class, 'registrarNovedad'])->name('registrarNovedad');
        Route::get('/novedades-lista', [SaludAnimalController::class, 'novedadesLista'])->name('novedadesLista');
        Route::get('/grafica-novedades', [SaludAnimalController::class, 'graficaNovedades'])->name('graficaNovedades'); // Para el gráfico de novedades

        // Tratamientos
        Route::get('/tratamientos', [SaludAnimalController::class, 'tratamientos'])->name('tratamientos');
        Route::post('/tratamientos', [SaludAnimalController::class, 'registrarTratamiento'])->name('registrarTratamiento');
        Route::get('/grafica-tratamientos', [SaludAnimalController::class, 'graficaTratamientos'])->name('graficaTratamientos'); // Para el gráfico de tratamientos
        Route::get('/tratamientos-lista', [SaludAnimalController::class, 'tratamientosLista'])->name('tratamientosLista');

        // Vacunación
        Route::get('/vacunacion', [SaludAnimalController::class, 'vacunacion'])->name('vacunacion');
        Route::post('/vacunacion', [SaludAnimalController::class, 'registrarVacuna'])->name('registrarVacuna');
    });



    // 🌾 MÓDULO POTREROS
    Route::prefix('potreros')->name('potreros.')->group(function () {
        Route::get('/', [PotreroController::class, 'index'])->name('index');
        Route::get('/crear', [PotreroController::class, 'create'])->name('create');
        Route::post('/', [PotreroController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [PotreroController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PotreroController::class, 'update'])->name('update');
        Route::delete('/{id}', [PotreroController::class, 'destroy'])->name('destroy');
        Route::get('/visualizar', [PotreroController::class, 'visualizar'])->name('visualizar');
        Route::post('/asignar', [PotreroController::class, 'asignarAnimal'])->name('asignar');
        Route::post('/mover', [PotreroController::class, 'moverAnimal'])->name('mover');
        Route::post('/eliminar-asignacion', [PotreroController::class, 'eliminarAsignacion'])->name('eliminarAsignacion');
        Route::get('/grafica-datos', [PotreroController::class, 'grafica'])->name('grafica');
    });

    // MODULO FICHAS
    Route::prefix('fichas')->name('fichas.')->group(function () {
        Route::get('/', [TrainingRecordController::class, 'index'])->name('index');
        Route::post('/', [TrainingRecordController::class, 'store'])->name('store');
        Route::put('/{trainingRecord}', [TrainingRecordController::class, 'update'])->name('update');
        Route::delete('/{trainingRecord}', [TrainingRecordController::class, 'destroy'])->name('destroy');
    });


    // MODULO APRENDICES
    Route::prefix('aprendices')->name('aprendices.')->group(function () {
        Route::get('/', [ApprenticeController::class, 'index'])->name('index');
        Route::post('/', [ApprenticeController::class, 'store'])->name('store');
        Route::put('/{apprentice}', [ApprenticeController::class, 'update'])->name('update');
        Route::delete('/{apprentice}', [ApprenticeController::class, 'destroy'])->name('destroy');
    });



    // MODULO DE TAREAS
    Route::prefix('tareas')->name('tareas.')->group(function () {
    Route::get('/', [App\Http\Controllers\TaskController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\TaskController::class, 'store'])->name('store');
    Route::put('/{task}', [App\Http\Controllers\TaskController::class, 'update'])->name('update');
    Route::delete('/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('destroy');
    Route::post('/{task}/verify', [App\Http\Controllers\TaskController::class, 'verify'])->name('verify');
});

});
