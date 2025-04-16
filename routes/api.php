<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;



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
});
