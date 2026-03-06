<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sancion;
use App\Models\User;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class SancionController extends Controller
{
    /**
     * Lista todas las sanciones activas e históricas.
     */
    public function index()
    {
        $sanciones = Sancion::with(['user', 'prestamo.elemento'])
            ->orderBy('fecha_fin', 'desc')
            ->paginate(15);

        return view('admin.sanciones.index', compact('sanciones'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        // Solo usuarios Sena pueden ser sancionados. 
        // Se excluye al administrador actual y a cualquier otro usuario con rol administrativo.
        $usuarios = User::where('id', '!=', auth()->id())
            ->whereHas('roles', function($q){
                $q->where('name', 'Usuario SENA');
            })
            ->whereDoesntHave('roles', function($q){
                $q->where('name', 'Lider Admin');
            })
            ->orderBy('name')->get();

        return view('admin.sanciones.create', compact('usuarios'));
    }

    /**
     * Almacena la sanción en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'motivo' => 'required|string|max:500',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'prestamo_id' => 'nullable|exists:prestamos,id'
        ]);

        $usuario = User::findOrFail($request->user_id);

        if ($usuario->hasRole('Lider Admin')) {
            return back()->with('error', 'No se puede sancionar a un administrador.');
        }

        $sancion = Sancion::create([
            'user_id' => $request->user_id,
            'prestamo_id' => $request->prestamo_id,
            'motivo' => $request->motivo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'Activa',
        ]);

        // Sincronizar estado en el usuario
        $usuario->update(['sancionado' => true]);

        return redirect()->route('admin.sanciones.index')
            ->with('success', 'Sanción aplicada. El usuario ha quedado bloqueado hasta la fecha final.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(Sancion $sancion)
    {
        return view('admin.sanciones.edit', compact('sancion'));
    }

    /**
     * Actualiza la sanción (útil para extender o acortar plazos).
     */
    public function update(Request $request, Sancion $sancion)
    {
        $request->validate([
            'motivo' => 'required|string|max:500',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        $sancion->update($request->all());

        // Sincronizar estado en el usuario basado en la nueva fecha de fin
        $seraSancionado = $sancion->fecha_fin >= now()->startOfDay();
        $sancion->user->update(['sancionado' => $seraSancionado]);

        return redirect()->route('admin.sanciones.index')
            ->with('success', 'Sanción actualizada correctamente.');
    }

    /**
     * Levanta o elimina la sanción.
     */
    public function destroy(Sancion $sancion)
    {
        $userId = $sancion->user_id;
        $sancion->delete();

        // Verificar si le quedan otras sanciones activas antes de quitar el bloqueo
        $tieneMasSanciones = Sancion::where('user_id', $userId)
            ->where('fecha_fin', '>=', now())
            ->exists();

        if (!$tieneMasSanciones) {
            User::where('id', $userId)->update(['sancionado' => false]);
        }

        return redirect()->route('admin.sanciones.index')
            ->with('success', 'Sanción levantada. El usuario ya puede solicitar equipos nuevamente.');
    }
}