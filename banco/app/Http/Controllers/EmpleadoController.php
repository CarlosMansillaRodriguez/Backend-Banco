<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    // Obtener todos los empleados con sus usuarios relacionados
    public function index()
    {
        $empleados = Empleado::with('usuario')->get();
        return response()->json($empleados);
    }

    public function store(Request $request)
    {
        // Solo administradores pueden registrar clientes
        if (!$request->user()->hasRol('Administrador')) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        // Validación
        $request->validate([
            'cargo' => 'required|string|max:100',
            'fecha_contrato' => 'required|date',
            'horario_entrada' => 'required|time',
            'horario_salida' => 'required|time',
            'usuario_id' => 'required|exists:usuarios,id'
        ]);

        // Generar contraseña
        $password = Hash::make($request->password);

        // Buscar el rol "Empleado"
        $rolEmpleado = Rol::where('nombre', 'Empleado')->first();
        if (!$rolEmpleado) {
            return response()->json(['error' => 'El rol Empleado no está registrado.'], 400);
        }

        // Crear usuario
        $usuario = Usuario::create(
            [
                'email' => $request->email,
                'password' => $password,
                'nombre_user' => $request->nombre_user,
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'genero' => $request->genero,
                'estado' => $request->estado,
                'fecha_nacimiento' => $request->fecha_nacimiento,
            ]
        );

        // Asignar rol al usuario
        $usuario->roles()->attach($rolEmpleado->id);

        // Crear empleado vinculado al usuario
        $empleado = Empleado::create([
            'cargo' => $request->cargo,
            'fecha_contrato' => $request->fecha_contrato,
            'horario_entrada' => $request->horario_entrada,
            'horario_salida' => $request->horario_salida,
            'usuario_id' => $usuario->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Empleado creado correctamente',
            'empleado' => $empleado->load('usuario')    
        ], 201);
    }

    public function show(string $id)
    {
        $empleado = Empleado::with('usuario')->find($id);

        if (!$empleado) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }

        return response()->json($empleado);
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }

        $request->validate([
            'cargo' => 'required|string|max:100',
            'fecha_contrato' => 'required|date',
            'horario_entrada' => 'required|string|max:10',
            'horario_salida' => 'required|string|max:10',
            'genero' => 'required|max:10',
            'estado' => 'required|boolean',
            'fecha_nacimiento' => 'required|date',
            'email' => 'required|email|unique:usuarios,email',
            'nombre_user' => 'required|string|min:2|max:100',
            'password' => 'nullable|string|min:6',
        ]);

        $empleado->update($request->only(['cargo', 'fecha_contrato', 'horario_entrada', 'horario_salida']));

        // Actualizar usuario relacionado
        if ($empleado->usuario) {
            $empleado->usuario->update($request->only([
                'email',
                'nombre_user',
                'password',
                'nombre',
                'apellido',
                'genero',
                'estado',
                'fecha_nacimiento'
            ]));
        }
        return response()->json([
            'status' => true,
            'message' => 'Empleado actualizado satisfactoriamente',
            'cliente' => $empleado->load('usuario')
        ]);
    } 

    public function destroy(string $id)
    {
        try {
            $empleado = Empleado::find($id);

            if (!$empleado) {
                return response()->json([
                    'status' => false,
                    'error' => 'Empleado no encontrado'
                ], 404);
            }

            // Alternar el estado (toggle) entre 0 y 1
            $empleado->estado = $empleado->estado == 1 ? 0 : 1;
            $empleado->save();

            return response()->json([
                'status' => true,
                'message' => $empleado->estado == 1 
                    ? 'Empleado reactivado correctamente' 
                    : 'Empleado eliminado correctamente',
                'empleado' => $empleado,
                'nuevo_estado' => $empleado->estado
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Error al cambiar el estado del empleado',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    /*
    public function destroy(string $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json(['status' => false, 'error' => 'Empleado no encontrado'], 404);
        }

        $usuario = $empleado->usuario;

        $empleado->delete();
        if ($usuario) {
            $usuario->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Empleado y usuario eliminado satisfactoriamente'
        ]);
    }
        */
}
