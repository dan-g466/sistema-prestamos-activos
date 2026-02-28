<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'elemento_id',
        'fecha_solicitud',
        'fecha_inicio',
        'fecha_devolucion_esperada',
        'fecha_devolucion_real',
        'estado', // Pendiente, Aceptado, Activo, Devuelto, Vencido, Rechazado
        'observaciones'
    ];

    // Formateo de fechas automático (Casts)
    protected function casts(): array
    {
        return [
            'fecha_solicitud' => 'datetime',
            'fecha_inicio' => 'datetime',
            'fecha_devolucion_esperada' => 'datetime',
            'fecha_devolucion_real' => 'datetime',
        ];
    }

    // Relación: El préstamo pertenece a un Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: El préstamo pertenece a un Elemento
    public function elemento()
    {
        return $this->belongsTo(Elemento::class);
    }

    // Relación: El préstamo puede tener sanciones asociadas
    public function sanciones()
    {
        return $this->hasMany(Sancion::class);
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::deleting(function ($prestamo) {
            // Eliminar sanciones vinculadas al préstamo
            $prestamo->sanciones()->delete();
        });
    }
}