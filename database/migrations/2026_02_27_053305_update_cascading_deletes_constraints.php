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
        // Update elementos table
        Schema::table('elementos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onDelete('cascade');
        });

        // Update prestamos table
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropForeign(['elemento_id']);
            $table->foreign('elemento_id')
                ->references('id')
                ->on('elementos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert prestamos table
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropForeign(['elemento_id']);
            $table->foreign('elemento_id')
                ->references('id')
                ->on('elementos')
                ->onDelete('restrict');
        });

        // Revert elementos table
        Schema::table('elementos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onDelete('restrict');
        });
    }
};
