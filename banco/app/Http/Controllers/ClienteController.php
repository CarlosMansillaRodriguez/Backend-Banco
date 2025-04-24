<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Cliente;

class ClienteController extends Controller
{
    // Obtener todos los clientes con sus usuarios relacionados
    public function index()
    {
        $clientes = Cliente::with('usuario')->get();
        return response()->json($clientes);
    }

    public function store(Request $request)
    {
        // Solo administradores pueden registrar clientes
        if (!$request->user()->hasRol('Administrador')) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        // Validación
        $request->validate([
            'ci' => 'required|unique:clientes',
            'nombre' => 'required|string|min:2|max:100',
            'apellido' => 'required|string|min:2|max:100',
            'telefono' => 'required|string',
            'direccion' => 'required|string',
            'genero' => 'required|max:10',
            'email' => 'required|email|unique:usuarios,email',
            'nombre_user' => 'required|string|min:2|max:100',
            'password' => 'nullable|string|min:6',
        ]);

        // Obtener o generar contraseña
        $password = $request->filled('password')
            ? Hash::make($request->password)
            : Hash::make($request->ci);

        // Buscar el rol "Cliente"
        $rolCliente = Rol::where('nombre', 'Cliente')->first();
        if (!$rolCliente) {
            return response()->json(['error' => 'El rol Cliente no está registrado.'], 400);
        }

        // Crear usuario
        $usuario = Usuario::create([
            'email' => $request->email,
            'password' => $password,
            'nombre_user' => $request->nombre_user,
        ]);

        // Asignar rol
        $usuario->roles()->attach($rolCliente->id);

        // Crear cliente vinculado al usuario
        $cliente = Cliente::create([
            'ci' => $request->ci,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'genero' => $request->genero,
            'usuario_id' => $usuario->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cliente creado satisfactoriamente',
            'cliente' => $cliente->load('usuario'),
        ], 201);
    }

    public function show(string $id)
    {
        $cliente = Cliente::with('usuario')->find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'string|min:2|max:100',
            'apellido' => 'string|min:2|max:100',
            'telefono' => 'string',
            'direccion' => 'string',
            'genero' => 'string|max:10',
            'email' => 'nullable|email|unique:usuarios,email,' . $cliente->usuario_id,
            'nombre_user' => 'nullable|string|min:2|max:100',
        ]);

        $cliente->update($request->only(['nombre', 'apellido', 'telefono', 'direccion', 'genero']));

        // Actualizar usuario relacionado
        if ($cliente->usuario) {
            if ($request->filled('email')) {
                $cliente->usuario->email = $request->email;
            }
            if ($request->filled('nombre_user')) {
                $cliente->usuario->nombre_user = $request->nombre_user;
            }
            $cliente->usuario->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Cliente actualizado satisfactoriamente',
            'cliente' => $cliente->load('usuario')
        ]);
    }

    public function destroy(string $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['status' => false, 'error' => 'Cliente no encontrado'], 404);
        }

        $usuario = $cliente->usuario;

        $cliente->delete();
        if ($usuario) {
            $usuario->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Cliente y usuario eliminado satisfactoriamente'
        ]);
    }
}
