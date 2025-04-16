<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // Listar todos los roles con sus permisos
    public function index()
    {
        $roles = Rol::with('permisos')->get();
        return response()->json($roles);
    }

    // Crear nuevo rol
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|unique:roles,nombre',
        ]);

        $rol = Rol::create($validated);

        return response()->json([
            'message' => 'Rol creado correctamente',
            'rol' => $rol
        ], 201);
    }

    // Actualizar un rol
    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|unique:roles,nombre,' . $id,
        ]);

        $rol->update($validated);

        return response()->json([
            'message' => 'Rol actualizado correctamente',
            'rol' => $rol
        ]);
    }

    // Eliminar rol (solo si no tiene usuarios)
    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);

        if ($rol->usuarios()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar un rol asignado a usuarios.'
            ], 409);
        }

        $rol->delete();

        return response()->json([
            'message' => 'Rol eliminado correctamente'
        ]);
    }

    // Asignar permisos a un rol
    public function asignarPermisos(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);

    $request->validate([
        'permisos' => 'required|array',
        'permisos.*' => 'exists:permisos,id',
    ]);

    $rol->permisos()->syncWithoutDetaching($request->permisos);

    return response()->json([
        'message' => 'Permisos asignados correctamente',
        'rol' => $rol->load('permisos')
    ]);
    }

    // Revocar un permiso específico de un rol
    public function revocarPermiso($id, $permisoId)
    {
        $rol = Rol::findOrFail($id);
        $rol->permisos()->detach($permisoId);

        return response()->json([
            'message' => 'Permiso revocado correctamente',
            'rol' => $rol->load('permisos')
        ]);
    }
}
