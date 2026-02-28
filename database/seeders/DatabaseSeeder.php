<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llamar a nuestro seeder de roles y usuarios
        $this->call([
            RoleSeeder::class,
        ]);
    }
}