<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->unsignedBigInteger('id_cuenta')->nullable();
            $table->unsignedBigInteger('id_transaccion')->nullable();
            $table->unsignedBigInteger('id_atm')->nullable();

            $table->string('tipo'); // Ej: 'Advertencia', 'Confirmación'
            $table->text('mensaje');
            $table->timestamp('fecha_envio')->useCurrent(); // o datetime()
            $table->string('estado')->default('no_leida'); // 'leida' o 'no_leida'

            // Claves foráneas
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('id_cuenta')->references('id')->on('cuentas')->onDelete('set null');
            $table->foreign('id_transaccion')->references('id')->on('transacciones')->onDelete('set null');
            $table->foreign('id_atm')->references('id')->on('atms')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
