<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('elemento_id')->constrained('elementos')->onDelete('restrict');
            
            $table->date('fecha_solicitud');
            $table->date('fecha_devolucion_esperada');
            $table->date('fecha_devolucion_real')->nullable();
            
            $table->enum('estado', ['Pendiente', 'Activo', 'Devuelto', 'Vencido', 'Rechazado'])->default('Pendiente');
            $table->text('observaciones')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};