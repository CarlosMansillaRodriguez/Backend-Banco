<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        Usuario::firstOrCreate(
            ['email' => 'admin@banco.com'],
            [
                'nombre_user' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );

        Usuario::firstOrCreate(
            ['email' => 'cliente@banco.com'],
            [
                'nombre_user' => 'cliente',
                'password' => Hash::make('12345678'),
                
            ]
        );
    }
}
