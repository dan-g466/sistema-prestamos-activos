<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Usamos SQL puro para modificar el ENUM de forma segura en MySQL
        DB::statement("ALTER TABLE prestamos MODIFY COLUMN estado ENUM('Pendiente', 'Aceptado', 'Activo', 'Por Confirmar', 'Devuelto', 'Vencido', 'Rechazado') DEFAULT 'Pendiente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertimos al estado original (ten cuidado si ya hay datos con los nuevos estados)
        DB::statement("ALTER TABLE prestamos MODIFY COLUMN estado ENUM('Pendiente', 'Activo', 'Devuelto', 'Vencido', 'Rechazado') DEFAULT 'Pendiente'");
    }
};
