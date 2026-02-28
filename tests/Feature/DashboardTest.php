<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * Tests de acceso al DASHBOARD ADMIN (Lider Admin)
 */
describe('Admin Dashboard', function () {

    beforeEach(function () {
        // Crear roles si no existen
        Role::firstOrCreate(['name' => 'Lider Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Usuario SENA', 'guard_name' => 'web']);
    });

    it('admin puede acceder al dashboard', function () {
        $admin = User::factory()->create(['documento' => '1001']);
        $admin->assignRole('Lider Admin');

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertStatus(200);
    });

    it('usuario sena no puede acceder al dashboard admin', function () {
        $usuario = User::factory()->create(['documento' => '2001']);
        $usuario->assignRole('Usuario SENA');

        $this->actingAs($usuario)
            ->get('/admin/dashboard')
            ->assertStatus(403);
    });

    it('invitado es redirigido al login desde dashboard admin', function () {
        $this->get('/admin/dashboard')
            ->assertRedirect('/login');
    });

    it('admin puede ver la lista de elementos', function () {
        $admin = User::factory()->create(['documento' => '1002']);
        $admin->assignRole('Lider Admin');

        $this->actingAs($admin)
            ->get('/admin/elementos')
            ->assertStatus(200);
    });

    it('admin puede ver la lista de prestamos', function () {
        $admin = User::factory()->create(['documento' => '1003']);
        $admin->assignRole('Lider Admin');

        $this->actingAs($admin)
            ->get('/admin/prestamos')
            ->assertStatus(200);
    });

    it('admin puede ver los reportes', function () {
        $admin = User::factory()->create(['documento' => '1004']);
        $admin->assignRole('Lider Admin');

        $this->actingAs($admin)
            ->get('/admin/reportes')
            ->assertStatus(200);
    });

    it('admin puede ver los movimientos', function () {
        $admin = User::factory()->create(['documento' => '1005']);
        $admin->assignRole('Lider Admin');

        $this->actingAs($admin)
            ->get('/admin/movimientos')
            ->assertStatus(200);
    });

    it('admin puede ver sanciones', function () {
        $admin = User::factory()->create(['documento' => '1006']);
        $admin->assignRole('Lider Admin');

        $this->actingAs($admin)
            ->get('/admin/sanciones')
            ->assertStatus(200);
    });

    it('admin puede ver backups', function () {
        $admin = User::factory()->create(['documento' => '1007']);
        $admin->assignRole('Lider Admin');

        $this->actingAs($admin)
            ->get('/admin/backups')
            ->assertStatus(200);
    });

    it('admin puede acceder al reporte pdf de inventario', function () {
        $admin = User::factory()->create(['documento' => '1008']);
        $admin->assignRole('Lider Admin');

        $this->actingAs($admin)
            ->get('/admin/reportes/pdf?tipo=inventario')
            ->assertStatus(200);
    });
});

/**
 * Tests de acceso al DASHBOARD USUARIO SENA
 */
describe('User Dashboard', function () {

    beforeEach(function () {
        Role::firstOrCreate(['name' => 'Lider Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Usuario SENA', 'guard_name' => 'web']);
    });

    it('usuario sena puede ver su dashboard', function () {
        $usuario = User::factory()->create(['documento' => '3001']);
        $usuario->assignRole('Usuario SENA');

        $this->actingAs($usuario)
            ->get('/usuario/dashboard')
            ->assertStatus(200);
    });

    it('admin no puede acceder al dashboard de usuario sena', function () {
        $admin = User::factory()->create(['documento' => '4001']);
        $admin->assignRole('Lider Admin');

        $this->actingAs($admin)
            ->get('/usuario/dashboard')
            ->assertStatus(403);
    });

    it('invitado es redirigido al login desde dashboard usuario', function () {
        $this->get('/usuario/dashboard')
            ->assertRedirect('/login');
    });

    it('usuario sena puede ver el catalogo', function () {
        $usuario = User::factory()->create(['documento' => '3002']);
        $usuario->assignRole('Usuario SENA');

        $this->actingAs($usuario)
            ->get('/usuario/catalogo')
            ->assertStatus(200);
    });

    it('usuario sena puede ver su historial', function () {
        $usuario = User::factory()->create(['documento' => '3003']);
        $usuario->assignRole('Usuario SENA');

        $this->actingAs($usuario)
            ->get('/usuario/historial')
            ->assertStatus(200);
    });
});
