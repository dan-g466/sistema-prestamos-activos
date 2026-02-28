<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sanciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('prestamo_id')->nullable()->constrained('prestamos')->onDelete('set null');

            $table->text('motivo');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['Activa', 'Cumplida'])->default('Activa');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanciones');
    }
};
