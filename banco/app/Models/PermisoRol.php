<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PermisoRol extends Model
{
    use HasFactory;

    protected $table = 'permiso_rol';

    protected $fillable = [
        'rol_id',
        'permiso_id',
    ];
}
