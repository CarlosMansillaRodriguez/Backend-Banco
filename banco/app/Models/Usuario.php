<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_user',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'usuario_rol');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    public function hasRol($nombre)
    {
        return $this->roles()->where('nombre', $nombre)->exists();
    }


}

