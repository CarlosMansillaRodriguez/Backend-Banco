<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'ci', 'nombre', 'apellido', 'telefono', 'direccion', 'genero', 'usuario_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function cuentas()
    {
        return $this->hasMany(Cuenta::class, 'cliente_id');
    }
}
