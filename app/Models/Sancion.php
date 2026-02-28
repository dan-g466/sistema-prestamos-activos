<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sancion extends Model
{
    use HasFactory;

    protected $table = 'sanciones'; // evita que Laravel pluralice a 'sancions'


    protected $fillable = [
        'user_id',
        'prestamo_id',
        'motivo',
        'fecha_inicio',
        'fecha_fin',
        'estado' // 'Activa', 'Cumplida'
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function prestamo() { return $this->belongsTo(Prestamo::class); }
}