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
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dateTime('fecha_solicitud')->change();
            $table->dateTime('fecha_devolucion_esperada')->change();
            $table->dateTime('fecha_devolucion_real')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->date('fecha_solicitud')->change();
            $table->date('fecha_devolucion_esperada')->change();
            $table->date('fecha_devolucion_real')->nullable()->change();
        });
    }
};
