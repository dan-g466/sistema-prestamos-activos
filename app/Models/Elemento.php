<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elemento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo_sena',
        'imagen',
        'estado', // Disponible, Prestado, Mantenimiento, Baja
        'categoria_id'
    ];

    // Relación: Un elemento pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación: Un elemento puede estar en muchos registros de préstamos (historial)
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    // Relación: Un elemento tiene muchos movimientos de inventario
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::deleting(function ($elemento) {
            // Eliminar préstamos vinculados al elemento (esto disparará el deleting de Prestamo)
            $elemento->prestamos->each->delete();

            // Eliminar movimientos vinculados al elemento
            $elemento->movimientos()->delete();
        });
    }
}