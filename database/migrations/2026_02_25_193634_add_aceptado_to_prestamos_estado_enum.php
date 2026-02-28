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
        // En Laragon/MySQL local se puede modificar el enum así. 
        // Para mayor compatibilidad en este sistema, usamos una sentencia cruda si es necesario,
        // pero Laravel 11 soporta mejor las modificaciones de columnas.
        Schema::table('prestamos', function (Blueprint $table) {
            $table->enum('estado', ['Pendiente', 'Aceptado', 'Activo', 'Devuelto', 'Vencido', 'Rechazado'])->default('Pendiente')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->enum('estado', ['Pendiente', 'Activo', 'Devuelto', 'Vencido', 'Rechazado'])->default('Pendiente')->change();
        });
    }
};
