<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cliente::create([
            'ci' => '112233',
            'nombre' => 'Juan Carlos',
            'apellido' => 'Lopez',
            'genero' => 'M',
            'telefono' => '123456789',
            'direccion' => 'Direccion 1',
            'usuario_id' => 2,
        ]);

        Cliente::create([
            'ci' => '223344',
            'nombre' => 'Maria Fernanda',
            'apellido' => 'Gonzalez',
            'genero' => 'F',
            'telefono' => '987654321',
            'direccion' => 'Direccion 2',
            'usuario_id' => 3,
        ]);
        Cliente::create([
            'ci' => '334455',
            'nombre' => 'Carlos Alberto',
            'apellido' => 'Martinez',
            'genero' => 'M',
            'telefono' => '456789123',
            'direccion' => 'Direccion 3',
            'usuario_id' => 4,
        ]);
        Cliente::create([
            'ci' => '445566',
            'nombre' => 'Ana Maria',
            'apellido' => 'Rodriguez',
            'genero' => 'F',
            'telefono' => '321654987',
            'direccion' => 'Direccion 4',
            'usuario_id' => 5,
        ]);
        Cliente::create([
            'ci' => '556677',
            'nombre' => 'Luis Fernando',
            'apellido' => 'Hernandez',
            'genero' => 'M',
            'telefono' => '654321789',
            'direccion' => 'Direccion 5',
            'usuario_id' => 6,
        ]);
        Cliente::create([
            'ci' => '667788',
            'nombre' => 'Sofia Isabel',
            'apellido' => 'Paredes',
            'genero' => 'F',
            'telefono' => '789123456',
            'direccion' => 'Direccion 6',
            'usuario_id' => 7,
        ]);
        Cliente::create([
            'ci' => '778899',
            'nombre' => 'Andres Felipe',
            'apellido' => 'Cruz',
            'genero' => 'M',
            'telefono' => '123789456',
            'direccion' => 'Direccion 7',
            'usuario_id' => 8,
        ]);
        Cliente::create([
            'ci' => '889900',
            'nombre' => 'Valentina Sofia',
            'apellido' => 'Guzman',
            'genero' => 'F',
            'telefono' => '456123789',
            'direccion' => 'Direccion 8',
            'usuario_id' => 9,
        ]);
        Cliente::create([
            'ci' => '990011',
            'nombre' => 'Sebastian David',
            'apellido' => 'Salazar',
            'genero' => 'M',
            'telefono' => '789456123',
            'direccion' => 'Direccion 9',
            'usuario_id' => 10,
        ]);
        Cliente::create([
            'ci' => '101112',
            'nombre' => 'Isabella Valentina',
            'apellido' => 'Ceballos',
            'genero' => 'F',
            'telefono' => '321987654',
            'direccion' => 'Direccion 10',
            'usuario_id' => 11,
        ]);
    }
}
