<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear los roles principales
        $roleAdmin = Role::create(['name' => 'Lider Admin']);
        $roleUser = Role::create(['name' => 'Usuario SENA']);

        // 2. Crear tu usuario Administrador Principal
        $admin = User::create([
            'name' => 'Administrador Principal',
            'documento' => '0000000000',
            'email' => 'admin@sena.edu.co',
            'password' => Hash::make('admin123'), // Contraseña: admin123
        ]);

        // 3. Asignarle el rol de Líder Admin
        $admin->assignRole($roleAdmin);
    }
}