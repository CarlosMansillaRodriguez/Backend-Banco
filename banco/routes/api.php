<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\DB;


// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout']);

    // Obtener datos del usuario autenticado
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    // CRUD de Usuarios
    Route::apiResource('usuarios', UsuarioController::class);
    Route::post('/usuarios/{id}/roles', [UsuarioController::class, 'asignarRoles']);
    Route::post('/usuarios/{id}/roles/revocar', [UsuarioController::class, 'revocarRoles']);


    // CRUD de Clientes
    Route::apiResource('clientes', ClienteController::class);

    // CRUD de Cuentas
    Route::apiResource('cuentas', CuentaController::class);

    // CRUD de Roles
    Route::apiResource('roles', RolController::class);
    

    // CRUD de Permisos
    Route::apiResource('permisos', PermisoController::class);
    Route::post('/permisos/asignar', [PermisoController::class, 'asignarPermiso']);
    Route::post('/permisos/desasignar', [PermisoController::class, 'desasignarPermiso']);
    Route::get('/permisos/rol/{rol_id}', [PermisoController::class, 'obtenerPermisos']);

    // CRUD de Bitácora (sólo admin quizás)
    Route::apiResource('bitacoras', BitacoraController::class);

    
});
Route::get('/db-check', function () {
    return response()->json([
        'base_de_datos_activa' => DB::connection()->getDatabaseName()
    ]);
});
Route::get('/verificar', function () {
    return response()->json(['mensaje' => 'Ruta funcionando correctamente']);
});