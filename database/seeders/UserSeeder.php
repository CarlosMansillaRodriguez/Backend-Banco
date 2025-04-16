<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'id_rol' => 1,
            'estado' => 'activo'
        ]);

        // son 10 los usuarios q se creo para los clientes
        User::create([
            'name' => 'Cliente',
            'email' => 'cliente1@example.com',
            'password' => Hash::make('12345678'),
            'id_rol' => 2,
            'estado' => 'activo'
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente2@example.com',
            'password' => Hash::make('12345678'),
            'id_rol' => 2,
            'estado' => 'activo'
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente3@example.com',
            'password' => Hash::make('12345678'),
            'id_rol' => 2,
            'estado' => 'activo'
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente4@example.com',
            'password' => Hash::make('12345678'),
            'id_rol' => 2,
            'estado' => 'activo'
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente5@example.com',
            'password' => Hash::make('12345678'),
            'id_rol' => 2,
            'estado' => 'activo'
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente6@example.com',
            'password' => Hash::make('12345678'),
            'id_rol' => 2,
            'estado' => 'activo'
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente7@example.com',
            'password' => Hash::make('12345678'),
            'id_rol' => 2,
            'estado' => 'activo'
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente8@example.com',
            'password' => Hash::make('12345678'),
            'id_rol' => 2,
            'estado' => 'activo'
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente9@example.com',
            'password' => Hash::make('12345678'),
            'id_rol' => 2,
            'estado' => 'activo'
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente10@example.com',
            'password' => Hash::make('12345678'),
            'id_rol' => 2,
            'estado' => 'activo'
        ]);
    }
}
