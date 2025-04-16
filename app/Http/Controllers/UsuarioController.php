<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'id_rol'   => 'required|integer',
            'estado'   => 'required|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Usuario creado correctamente',
            'user' => $user
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $id,
        'id_rol' => 'sometimes|integer',
        'estado' => 'sometimes|string',
    ]);

    $user->update($validated);

    return response()->json([
        'message' => 'Usuario actualizado correctamente',
        'user' => $user
    ], 200);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado correctamente'
        ]);
    }

}
