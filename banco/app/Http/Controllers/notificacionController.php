<?php

namespace App\Http\Controllers;

use App\Models\Notificacione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class notificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::usuario()->id;

        $notificaciones = Notificacione::where('id_cliente', $userId)
                                      ->orWhereNull('id_cliente')
                                      ->latest()
                                      ->get();

        return response()->json([
            'success' => true,
            'notificaciones' => $notificaciones,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

/**
     * Mostrar una notificación específica por ID.
     */
    public function show(Notificacione $notification)
    {
        return response()->json([
            'success' => true,
            'notificacion' => $notification,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
        /**
     * Marcar una notificación específica como leída.
     */
    public function markAsRead(Notificacione $notification)
    {
        if ($notification->id_cliente && $notification->id_cliente !== Auth::user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta notificación.',
            ], 403);
        }

        $notification->update(['estado' => 'leida']);

        return response()->json([
            'success' => true,
            'message' => 'Notificación marcada como leída.',
        ]);
    }

    /**
     * Marcar todas las notificaciones como leídas.
     */
    public function markAllAsRead()
    {
        $userId = Auth::user()->id;

        Notificacione::where('id_cliente', $userId)->update(['estado' => 'leida']);

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones han sido marcadas como leídas.',
        ]);
    }

    
}
