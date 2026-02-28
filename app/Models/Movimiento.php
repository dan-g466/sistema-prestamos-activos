<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'elemento_id',
        'user_id', // Quién operó el cambio (Admin)
        'tipo_movimiento', // 'Entrada', 'Salida', 'Mantenimiento'
        'descripcion'
    ];

    public function elemento() { return $this->belongsTo(Elemento::class); }
    public function user() { return $this->belongsTo(User::class, 'user_id'); }
}