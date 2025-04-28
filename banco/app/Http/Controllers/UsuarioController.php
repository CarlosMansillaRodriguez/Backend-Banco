<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Rol;

class UsuarioController extends Controller
{
    // Obtener todos los usuarios con sus roles
    public function index()
    {
        $usuarios = Usuario::with('roles')->get();
        return response()->json($usuarios);
    }

    // Crear un nuevo usuario y asignar roles
    public function store(Request $request)
    {
        $request->validate([
            'nombre_user' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'genero' => 'required|string|max:1',
            'estado' => 'required|string|max:1',
            'fecha_nacimiento' => 'required|date',
            // Validación para los roles
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:rols,id'
        ]);

        $usuario = Usuario::create([
            'nombre_user' => $request->nombre_user,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'genero' => $request->genero,
            'estado' => $request->estado,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        // Asignar roles al usuario
        $usuario->roles()->attach($request->roles);

        return response()->json([
            'status' => true,
            'message' => 'Usuario creado correctamente',
            'usuario' => $usuario->load('roles')
        ], 201);
    }

    // Mostrar un usuario específico con roles
    public function show($id)
    {
        $usuario = Usuario::with(['roles', 'bitacoras'])->find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    // Actualizar datos y roles de un usuario
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $request->validate([
            'nombre_user' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:rols,id'
        ]);

        if ($request->has('nombre_user')) $usuario->nombre_user = $request->nombre_user;
        if ($request->has('email')) $usuario->email = $request->email;
        if ($request->filled('password')) $usuario->password = Hash::make($request->password);
        if ($request->has('nombre')) $usuario->nombre = $request->nombre;
        if ($request->has('apellido')) $usuario->apellido = $request->apellido;
        if ($request->has('genero')) $usuario->genero = $request->genero;
        if ($request->has('estado')) $usuario->estado = $request->estado;
        if ($request->has('fecha_nacimiento')) $usuario->fecha_nacimiento = $request->fecha_nacimiento;
        $usuario->save();

        // Si se enviaron nuevos roles, sincronizarlos
        if ($request->has('roles')) {
            $usuario->roles()->sync($request->roles);
        }

        return response()->json([
            'status' => true,
            'message' => 'Usuario actualizado correctamente',
            'usuario' => $usuario->load('roles')
        ]);
    }

    // Eliminar un usuario y sus relaciones con roles
    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Eliminar relaciones en la tabla pivote
        $usuario->roles()->detach();

        // Eliminar usuario
        $usuario->delete();

        return response()->json([
            'status' => true,
            'message' => 'Usuario eliminado correctamente'
        ]);
    }

    public function asignarRoles(Request $request, $id)
    {
        $usuario = Usuario::find($id);

    if (!$usuario) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }

    $request->validate([
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,id'
    ]);

    $usuario->roles()->syncWithoutDetaching($request->roles);

    return response()->json([
        'message' => 'Roles asignados correctamente',
        'usuario' => $usuario->load('roles')
    ]);
}

// Revocar uno o más roles de un usuario
public function revocarRoles(Request $request, $id)
{
    $usuario = Usuario::find($id);

    if (!$usuario) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }

    $request->validate([
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,id'
    ]);

    // Elimina solo los roles indicados
    $usuario->roles()->detach($request->roles);

    return response()->json([
        'message' => 'Roles revocados correctamente',
        'usuario' => $usuario->load('roles')
    ]);
}

}
