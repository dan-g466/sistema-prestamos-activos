<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Solo mostramos a los que tienen rol de 'Usuario SENA'
        $usuarios = User::role('Usuario SENA')->orderBy('name', 'asc')->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function show(User $user)
    {
        // Ver el perfil del aprendiz y su historial de préstamos
        $user->load(['prestamos.elemento', 'sanciones']);
        return view('admin.usuarios.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.usuarios.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'documento' => 'required|numeric|unique:users,documento,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email', 'documento']));

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Información del aprendiz actualizada correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado satisfactoriamente del sistema.');
    }
}