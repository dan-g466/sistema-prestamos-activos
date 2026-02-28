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
        Schema::table('users', function (Blueprint $table) {
            // Añadimos documento (importante para el SENA)
            // Se usa after('id') para que quede al inicio de la tabla
            if (!Schema::hasColumn('users', 'documento')) {
                $table->string('documento')->unique()->nullable()->after('id');
            }

            // Añadimos el estado de sanción
            // Por defecto es 0 (falso), indicando que el usuario está al día
            if (!Schema::hasColumn('users', 'sancionado')) {
                $table->boolean('sancionado')->default(false)->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminamos las columnas en caso de hacer rollback
            $table->dropColumn(['documento', 'sancionado']);
        });
    }
};