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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cuenta')->unique();
            $table->string('estado');
            $table->date('fecha_apertura');
            $table->decimal('saldo', 100, 2);
            $table->string('tipo_cuenta');
            $table->string('moneda');
            $table->decimal('intereses',5,2);
            $table->unsignedInteger('limite_retiro_diario');

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')
                    ->on('clientes')->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
