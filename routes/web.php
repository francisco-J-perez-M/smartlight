<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\UserController;


// Ruta principal
Route::get('/', [PosteController::class, 'index'])->name('home');

// Rutas para Postes
Route::get('/postes', [PosteController::class, 'index'])->name('postes.index');
Route::get('/postes/create', [PosteController::class, 'create'])->name('postes.create');
Route::post('/postes', [PosteController::class, 'store'])->name('postes.store');
Route::get('/postes/{id}', [PosteController::class, 'show'])->name('postes.show');
Route::put('/postes/{id}', [PosteController::class, 'update'])->name('postes.update');
Route::delete('/postes/{id}', [PosteController::class, 'destroy'])->name('postes.destroy');

// Rutas para Sensores
Route::get('/sensores', [SensorController::class, 'index'])->name('sensores.index');
Route::post('/sensores', [SensorController::class, 'store'])->name('sensores.store');
Route::get('/sensores/{id}', [SensorController::class, 'show'])->name('sensores.show');
Route::put('/sensores/{id}', [SensorController::class, 'update'])->name('sensores.update');
Route::delete('/sensores/{id}', [SensorController::class, 'destroy'])->name('sensores.destroy');

// Rutas para Alertas
Route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');
Route::post('/alertas', [AlertaController::class, 'store'])->name('alertas.store');
Route::get('/alertas/{id}', [AlertaController::class, 'show'])->name('alertas.show');
Route::put('/alertas/{id}', [AlertaController::class, 'update'])->name('alertas.update');
Route::delete('/alertas/{id}', [AlertaController::class, 'destroy'])->name('alertas.destroy');

// Rutas para Usuarios
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');