<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elementos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo_sena')->unique(); // Placa de inventario
            $table->string('foto_url')->nullable();
            $table->enum('estado', ['Disponible', 'Prestado', 'En Mantenimiento', 'Dado de Baja'])->default('Disponible');
            
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('restrict');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elementos');
    }
};