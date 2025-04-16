<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuenta extends Model
{
    use HasFactory;
    protected $table = 'cuentas';

    protected $fillable = [
        'numero_cuenta',
        'estado',
        'fecha_apertura',
        'fecha_cierre',
        'saldo',
        'tipo_cuenta',
        'moneda',
        'intereses',
        'limite_retiro_diario',
        'cliente_id', // Asegúrate de que este campo esté en la tabla de cuentas
    ];



    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

}
