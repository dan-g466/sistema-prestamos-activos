<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSenaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Inmobiliaria',
                'descripcion' => 'Muebles, sillas, mesas y elementos de oficina o taller.'
            ],
            [
                'nombre' => 'Tecnología',
                'descripcion' => 'Equipos de cómputo, periféricos, software y dispositivos electrónicos.'
            ],
            [
                'nombre' => 'Papelería',
                'descripcion' => 'Insumos de oficina, papel, blocks y material consumible.'
            ],
            [
                'nombre' => 'Deportiva',
                'descripcion' => 'Balones, mallas, pesas y elementos para actividad física.'
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate(
                ['nombre' => $categoria['nombre']],
                ['descripcion' => $categoria['descripcion']]
            );
        }
    }
}
