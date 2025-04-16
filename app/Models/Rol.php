<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = ['nombre'];

    // Relación con permisos
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'permiso_rol', 'rol_id', 'permiso_id');
    }

    // Relación con usuarios (si quieres ver los usuarios que tienen este rol)
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol');
    }
}
