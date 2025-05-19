<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AtmController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\TarjetaController;
use App\Http\Controllers\CelularController;
use App\Http\Controllers\ReporteController;


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

    // CRUD de USUARIOS
    Route::apiResource('usuarios', UsuarioController::class);
    Route::post('/usuarios/{id}/roles', [UsuarioController::class, 'asignarRoles']);
    Route::post('/usuarios/{id}/roles/revocar', [UsuarioController::class, 'revocarRoles']);

    // CRUD de EMPLEADOS
    Route::apiResource('empleados', EmpleadoController::class);

    // CRUD de CLIENTES
    Route::apiResource('clientes', ClienteController::class);

    // CRUD de CUENTAS
    Route::apiResource('cuentas', CuentaController::class);

    // CRUD de ROLES
    Route::apiResource('roles', RolController::class);
    Route::get('/roles/{id}/permisos', [RolController::class, 'permisos']);

    // CRUD de PERMISOS
    Route::apiResource('permisos', PermisoController::class);
    Route::post('/permisos/asignar', [PermisoController::class, 'asignarPermiso']);
    Route::post('/permisos/desasignar', [PermisoController::class, 'desasignarPermiso']);
    Route::get('/permisos/rol/{rol_id}', [PermisoController::class, 'obtenerPermisos']);

    // CRUD de Bitácora (sólo admin quizás)
    Route::apiResource('bitacoras', BitacoraController::class);
    // CRUD de ATM'S
    Route::apiResource('atms', AtmController::class);
    //CRUD de TECNICO
    Route::apiResource('tecnicos', TecnicoController::class);   

    // CRUD de REPORTE
    Route::apiResource('reportes', ReporteController::class);

    // REGISTRO POR CELULAR sin token

    Route::post('/celular/registrar-sin-token', [CelularController::class, 'registrarConCredenciales']);

});
Route::get('/db-check', function () {
    return response()->json([
        'base_de_datos_activa' => DB::connection()->getDatabaseName()
    ]);
});
Route::get('/verificar', function () {
    return response()->json(['mensaje' => 'Ruta funcionando correctamente']);
});
//Modificado por Carlos
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tarjetas', [TarjetaController::class, 'index']);
    Route::post('/tarjetas', [TarjetaController::class, 'store']);
    Route::get('/tarjetas/{id}', [TarjetaController::class, 'show']);
    Route::put('/tarjetas/{id}', [TarjetaController::class, 'update']);
    Route::delete('/tarjetas/{id}', [TarjetaController::class, 'destroy']);
});
