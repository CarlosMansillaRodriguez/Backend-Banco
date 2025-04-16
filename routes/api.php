<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CuentaController;




// Ruta pública de login
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas por token (autenticación Sanctum)
Route::middleware('apiauth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rutas para Usuarios

    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::post('/usuarios', [UsuarioController::class, 'store']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

    Route::get('/roles', [RolController::class, 'index']);
    Route::post('/roles', [RolController::class, 'store']);
    Route::put('/roles/{id}', [RolController::class, 'update']);
    Route::delete('/roles/{id}', [RolController::class, 'destroy']);

    Route::post('/roles/{id}/permisos', [RolController::class, 'asignarPermisos']);

    Route::delete('/roles/{id}/permisos/{permiso}', [RolController::class, 'revocarPermiso']);

    // rutas de los clientes
    Route::get('/clientes', [ClienteController::class, 'index']);
    Route::post('/clientes', [ClienteController::class, 'store']);
    Route::get('/clientes/{id}', [ClienteController::class, 'show']);
    Route::put('/clientes/{id}', [ClienteController::class, 'update']);
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);

    // Rutas para cuentas
    Route::get('/cuentas', [CuentaController::class, 'index']);
    Route::post('/cuentas', [CuentaController::class, 'store']);
    Route::get('/cuentas/{id}', [CuentaController::class, 'show']);
    Route::put('/cuentas/{id}', [CuentaController::class, 'update']);
    Route::delete('/cuents/{id}', [CuentaController::class, 'destroy']);

});
