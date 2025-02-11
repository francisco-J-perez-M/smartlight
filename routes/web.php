<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\UsuarioController;

// Rutas para Postes
Route::get('/', [PosteController::class, 'index']);
Route::get('/postes/{id}', [PosteController::class, 'show']);
Route::post('/postes', [PosteController::class, 'store']);
Route::put('/postes/{id}', [PosteController::class, 'update']);
Route::delete('/postes/{id}', [PosteController::class, 'destroy']);

// Rutas para Sensores
Route::get('/sensores', [SensorController::class, 'index']);
Route::get('/sensores/{id}', [SensorController::class, 'show']);
Route::post('/sensores', [SensorController::class, 'store']);
Route::put('/sensores/{id}', [SensorController::class, 'update']);
Route::delete('/sensores/{id}', [SensorController::class, 'destroy']);

// Rutas para Alertas
Route::get('/alertas', [AlertaController::class, 'index']);
Route::get('/alertas/{id}', [AlertaController::class, 'show']);
Route::post('/alertas', [AlertaController::class, 'store']);
Route::put('/alertas/{id}', [AlertaController::class, 'update']);
Route::delete('/alertas/{id}', [AlertaController::class, 'destroy']);

// Rutas para Usuarios
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);