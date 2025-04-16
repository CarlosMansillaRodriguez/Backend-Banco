<?php

namespace Database\Seeders;

use App\Models\Cuenta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cuenta::created([
            'numero_cuenta'=> '100123456789',
            'estado'=> 'Activa',
            'fecha_apertura'=> '2025-04-15',
            'saldo'=> 1500.50,
            'tipo_cuenta'=> 'Ahorro de ahorro',
            'moneda'=> 'BOB',
            'intereses'=> 1.25,
            'limite_retiro_diario'=> 3000,
            'cliente_id'=> 5,
        ]);
    }
}
