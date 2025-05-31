<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacione extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';

    protected $fillable = [
        'id_cliente',
        'id_cuenta',
        'id_transaccion',
        'id_atm',
        'tipo',
        'mensaje',
        'estado',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }

    // Relación con Cuenta
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'id_cuenta', 'id');
    }

    // Relación con Transacción
    public function transaccion()
    {
        return $this->belongsTo(Transaccione::class, 'id_transaccion', 'id');
    }

    // Relación con ATM
    public function atm()
    {
        return $this->belongsTo(Atm::class, 'id_atm', 'id');
    }
}
