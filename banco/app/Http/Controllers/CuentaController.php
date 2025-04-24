<?php

namespace App\Http\Controllers;
use App\Models\Cuenta;


use Illuminate\Http\Request;

class CuentaController extends Controller
{
    public function index()
    {
        // Obtener todas las cuentas
        $cuentas = Cuenta::all();
        return response()->json($cuentas);
    }
    public function create()
    {
        // Aquí puedes implementar la lógica para mostrar el formulario de creación de una nueva cuenta
    }
    public function store(Request $request)
    {
        
        // Validación de datos
        $request->validate([
            'numero_cuenta' => 'required|string|unique:cuentas,numero_cuenta',
            'estado' => 'required|string',
            'fecha_de_apertura' => 'required|date',
            'saldo' => 'required|numeric|min:0',
            'tipo_de_cuenta' => 'required|string',
            'moneda' => 'required|string',
            'intereses' => 'required|numeric|between:0,99.99',
            'limite_de_retiro' => 'required|numeric|min:0',
            'cliente_id' => 'required|exists:clientes,id'
        ]);


        // Crear la cuenta
        $cuenta = Cuenta::create($request->all());
        
        if (!$cuenta) {
            return response()->json([
                'status' => false,
                'error' => 'No se pudo crear la cuenta',
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Cuenta creada satisfactoriamente',
            'cuenta' => $cuenta
        ], 201);
    }

    public function show($numero_cuenta)
    {
        // Obtener una cuenta específica
        $cuenta = Cuenta::findOrFail($numero_cuenta);

        if (!$cuenta) {
            return response()->json([
                'status' => false,
                'error' => 'No se encontró el cuenta',
            ], 404);
        }

        return response()->json($cuenta);
    }
    public function edit($id)
    {
        // Aquí puedes implementar la lógica para mostrar el formulario de edición de una cuenta
    }
    public function update(Request $request, $numero_cuenta)
    {
        // Validación de datos
        $request->validate([
            'numero_cuenta' => 'required|string|unique:cuentas,numero_cuenta',
            'estado' => 'required|string',
            'fecha_apertura' => 'required|date',
            'saldo' => 'required|numeric|min:0',
            'tipo_cuenta' => 'required|string',
            'moneda' => 'required|string',
            'intereses' => 'required|numeric|between:0,99.99',
            'limite_retiro_diario' => 'required|integer|min:0',
        ]);

        // Actualizar la cuenta
        $cuenta = Cuenta::findOrFail($numero_cuenta);

        if (!$cuenta) {
            return response()->json([
                'status' => false,
                'error' => 'No se encontró el cuenta',
            ], 404);
        }

        $cuenta->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Cuenta actualizado satisfactoriamente',
            'cuenta' => $cuenta
        ], 200);
    }
    public function destroy($numero_cuenta)
    {
        $cuenta = Cuenta::findOrFail($numero_cuenta);

        if (!$cuenta) {
            return response()->json([
                'status' => false,
                'error' => 'No se encontró la cuenta',
            ], 404);
        }

        $cuenta->delete();

        return response()->json([
            'status' => true,
            'message' => 'Cuenta eliminado satisfactoriamente',
            'cuenta' => $cuenta,
        ], 200);
    }
    public function getCuentasByCliente($clienteId)
    {
        // Obtener todas las cuentas de un cliente específico
        $cuentas = Cuenta::where('cliente_id', $clienteId)->get();

        return response()->json($cuentas);
    }

    public function getCuentasByEstado($estado)
    {
        // Obtener todas las cuentas con un estado específico
        $cuentas = Cuenta::where('estado', $estado)->get();

        return response()->json($cuentas);
    }
    public function getCuentasByTipo($tipo)
    {
        // Obtener todas las cuentas de un tipo específico
        $cuentas = Cuenta::where('tipo_cuenta', $tipo)->get();

        return response()->json($cuentas);
    }
    public function getCuentasByMoneda($moneda)
    {
        // Obtener todas las cuentas de una moneda específica
        $cuentas = Cuenta::where('moneda', $moneda)->get();

        return response()->json($cuentas);
    }
    public function getCuentasByFechaApertura($fecha)
    {
        // Obtener todas las cuentas abiertas en una fecha específica
        $cuentas = Cuenta::whereDate('fecha_apertura', $fecha)->get();

        return response()->json($cuentas);
    }
    public function getCuentasByFechaCierre($fecha)
    {
        // Obtener todas las cuentas cerradas en una fecha específica
        $cuentas = Cuenta::whereDate('fecha_cierre', $fecha)->get();

        return response()->json($cuentas);
    }
}
