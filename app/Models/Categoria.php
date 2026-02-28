<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion'];

    // Relación: Una categoría tiene muchos elementos (HU-LA-04)
    public function elementos()
    {
        return $this->hasMany(Elemento::class);
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::deleting(function ($categoria) {
            // Eliminar elementos vinculados a la categoría (esto disparará el deleting de Elemento)
            $categoria->elementos->each->delete();
        });
    }
}