<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportImportController;
use App\Http\Controllers\GraficasController;


Route::post('/login', [AuthController::class, 'login']);
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', [AuthController::class, 'home'])->name('home');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rutas para Postes
Route::get('/postes', [PosteController::class, 'index'])->name('postes.index');
Route::get('/postes/create', [PosteController::class, 'create'])->name('postes.create');
Route::post('/postes', [PosteController::class, 'store'])->name('postes.store');
Route::get('/postes/{id}', [PosteController::class, 'show'])->name('postes.show');
Route::get('/postes/{id}/edit', [PosteController::class, 'edit'])->name('postes.edit');
Route::put('/postes/{id}', [PosteController::class, 'update'])->name('postes.update');
Route::delete('/postes/{id}', [PosteController::class, 'destroy'])->name('postes.destroy');

// Rutas para Sensores
Route::get('/sensores', [SensorController::class, 'index'])->name('sensores.index');
Route::get('/sensores/create', [SensorController::class, 'create'])->name('sensores.create');
Route::post('/sensores', [SensorController::class, 'store'])->name('sensores.store');
Route::get('/sensores/{id}', [SensorController::class, 'show'])->name('sensores.show');
Route::put('/sensores/{id}', [SensorController::class, 'update'])->name('sensores.update');
Route::get('/sensores/{id}/edit', [SensorController::class, 'edit'])->name('sensores.edit');
Route::delete('/sensores/{id}', [SensorController::class, 'destroy'])->name('sensores.destroy');

// Rutas para Alertas
Route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');
Route::get('/alertas/create', [AlertaController::class, 'create'])->name('alertas.create');
Route::post('/alertas', [AlertaController::class, 'store'])->name('alertas.store');
Route::get('/alertas/search', [AlertaController::class, 'search'])->name('alertas.search');
Route::get('/alertas/{id}', [AlertaController::class, 'show'])->name('alertas.show');
Route::get('/alertas/{id}/edit', [AlertaController::class, 'edit'])->name('alertas.edit');
Route::put('/alertas/{id}', [AlertaController::class, 'update'])->name('alertas.update');
Route::delete('/alertas/{id}', [AlertaController::class, 'destroy'])->name('alertas.destroy');


// Rutas para Usuarios
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/search', [UserController::class, 'search'])->name('usuarios.search');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit');

//rutas para importaciones y exportaciones desde exel
Route::get('/exportar-usuarios', [ExportImportController::class, 'exportUsuarios'])->name('usuarios.export');
Route::post('/importar-usuarios', [ExportImportController::class, 'importUsuarios'])->name('usuarios.import');
Route::get('/exportar-alertas', [ExportImportController::class, 'exportAlertas'])->name('alertas.export');
Route::post('/importar-alertas', [ExportImportController::class, 'importAlertas'])->name('alertas.import');
Route::get('/exportar-sensores', [ExportImportController::class, 'exportSensores'])->name('sensores.export');
Route::post('/importar-sensores', [ExportImportController::class, 'importSensores'])->name('sensores.import');
Route::get('/exportar-postes', [ExportImportController::class, 'exportPostes'])->name('postes.export');
Route::post('/importar-postes', [ExportImportController::class, 'importPostes'])->name('postes.import');

// Ruta para la vista de gráficas
Route::get('/graficas/usuarios', [GraficasController::class, 'usuarios'])->name('graficas.usuarios');
Route::get('/graficas/alertas', [GraficasController::class, 'alertas'])->name('graficas.alertas');
Route::get('/graficas/postes', [GraficasController::class, 'postes'])->name('graficas.postes');
Route::get('/graficas/sensores', [GraficasController::class, 'sensores'])->name('graficas.sensores');