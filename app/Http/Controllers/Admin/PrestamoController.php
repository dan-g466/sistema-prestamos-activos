<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use App\Models\Movimiento;
use App\Notifications\PrestamoStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    /**
     * Lista todos los préstamos.
     */
    public function index()
    {
        $prestamos = Prestamo::with(['user', 'elemento.categoria'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.prestamos.index', compact('prestamos'));
    }

    /**
     * Filtra y muestra solo los préstamos cuya fecha de devolución ya pasó.
     */
    public function vencidos()
    {
        $prestamos = Prestamo::where('estado', 'Activo')
            ->where('fecha_devolucion_esperada', '<', now())
            ->with(['user', 'elemento'])
            ->orderBy('fecha_devolucion_esperada', 'asc')
            ->paginate(15);

        return view('admin.prestamos.vencidos', compact('prestamos'));
    }

    /**
     * Acepta una solicitud pendiente (Primer paso).
     */
    public function aceptar(Prestamo $prestamo)
    {
        if ($prestamo->estado !== 'Pendiente') {
            return back()->with('error', 'Solo se pueden aceptar solicitudes pendientes.');
        }

        $prestamo->update(['estado' => 'Aceptado']);

        // Notificar al usuario
        $prestamo->user->notify(new PrestamoStatusUpdated($prestamo, "Tu solicitud del equipo '{$prestamo->elemento->nombre}' ha sido ACEPTADA. Puedes pasar a recogerlo."));

        Movimiento::create([
            'elemento_id' => $prestamo->elemento_id,
            'user_id' => Auth::id(),
            'tipo_movimiento' => 'Aprobación',
            'descripcion' => "Solicitud aceptada. Pendiente por entrega física a: " . $prestamo->user->name,
        ]);

        return back()->with('success', 'Solicitud aceptada. Ahora puedes proceder con la entrega física.');
    }

    /**
     * Registra la entrega física del equipo (Segundo paso).
     */
    public function entregar(Prestamo $prestamo)
    {
        if ($prestamo->estado !== 'Aceptado') {
            return back()->with('error', 'El préstamo debe estar en estado Aceptado para poder entregarlo.');
        }

        $prestamo->update(['estado' => 'Activo']);
        $prestamo->elemento->update(['estado' => 'Prestado']);

        Movimiento::create([
            'elemento_id' => $prestamo->elemento_id,
            'user_id' => Auth::id(),
            'tipo_movimiento' => 'Entrega',
            'descripcion' => "Equipo entregado físicamente a: " . $prestamo->user->name,
        ]);

        return back()->with('success', 'Equipo entregado. El préstamo ahora está Activo.');
    }

    /**
     * Rechaza una solicitud.
     */
    public function rechazar(Prestamo $prestamo)
    {
        $prestamo->update(['estado' => 'Rechazado']);
        
        // Notificar al usuario
        $prestamo->user->notify(new PrestamoStatusUpdated($prestamo, "Tu solicitud del equipo '{$prestamo->elemento->nombre}' ha sido RECHAZADA."));
        
        // Liberar el equipo tras el rechazo para que vuelva al catálogo
        $prestamo->elemento->update(['estado' => 'Disponible']);

        return back()->with('success', 'Solicitud rechazada. El equipo vuelve a estar disponible.');
    }

    /**
     * Registra que el equipo ha sido entregado pero está pendiente de revisión (Devolución iniciada).
     */
    public function finalizar(Request $request, Prestamo $prestamo)
    {
        $request->validate(['observaciones' => 'nullable|string|max:500']);

        $prestamo->update([
            'fecha_devolucion_real' => now(),
            'estado' => 'Por Confirmar',
            'observaciones' => $request->observaciones
        ]);

        // El equipo permanece como 'Prestado' o pasa a un estado intermedio si existiera, 
        // pero NO vuelve a 'Disponible' hasta la confirmación final.

        Movimiento::create([
            'elemento_id' => $prestamo->elemento_id,
            'user_id' => Auth::id(),
            'tipo_movimiento' => 'Devolución Iniciada',
            'descripcion' => "Equipo entregado por: " . $prestamo->user->name . ". Pendiente de confirmación por el administrador.",
        ]);

        return back()->with('success', 'La entrega ha sido registrada. Por favor, confirme el estado del equipo para finalizar el proceso.');
    }

    /**
     * Confirma la recepción definitiva del equipo y lo reintegra al inventario.
     */
    public function confirmarDevolucion(Prestamo $prestamo)
    {
        if ($prestamo->estado !== 'Por Confirmar') {
            return back()->with('error', 'Solo se pueden confirmar devoluciones en estado "Por Confirmar".');
        }

        $prestamo->update([
            'estado' => 'Devuelto'
        ]);

        $prestamo->elemento->update(['estado' => 'Disponible']);

        // Notificar al usuario que su devolución fue confirmada y ya está en el historial
        $prestamo->user->notify(new PrestamoStatusUpdated($prestamo, "El administrador ha confirmado la recepción del equipo '{$prestamo->elemento->nombre}'. El préstamo ha sido finalizado y ya puedes consultarlo en tu historial."));

        Movimiento::create([
            'elemento_id' => $prestamo->elemento_id,
            'user_id' => Auth::id(),
            'tipo_movimiento' => 'Devolución Confirmada',
            'descripcion' => "Equipo recibido y confirmado de: " . $prestamo->user->name . ". Reintegrado al inventario.",
        ]);

        return back()->with('success', 'Préstamo finalizado exitosamente. El equipo ya está disponible en el inventario.');
    }

    /**
     * Muestra el detalle de un préstamo.
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo->load(['user', 'elemento.categoria']);
        return view('admin.prestamos.show', compact('prestamo'));
    }

    /**
     * Muestra formulario de edición para corregir errores manuales.
     */
    public function edit(Prestamo $prestamo)
    {
        return view('admin.prestamos.edit', compact('prestamo'));
    }

    /**
     * Actualiza el registro del préstamo.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,Aceptado,Activo,Por Confirmar,Devuelto,Rechazado',
            'fecha_devolucion_esperada' => 'required|date',
            'fecha_devolucion_real' => 'nullable|date',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $prestamo->update($request->all());

        return redirect()->route('admin.prestamos.show', $prestamo)->with('success', 'Registro actualizado correctamente.');
    }

    /**
     * Elimina el registro del préstamo (Uso excepcional).
     */
    public function destroy(Prestamo $prestamo)
    {
        // Liberar el equipo si el préstamo estaba Activo o Pendiente antes de borrar el registro
        if (in_array($prestamo->estado, ['Activo', 'Pendiente'])) {
            $prestamo->elemento->update(['estado' => 'Disponible']);
        }

        $prestamo->delete();
        return redirect()->route('admin.prestamos.index')->with('success', 'Registro eliminado del historial.');
    }
}