<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SalidaController;


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
