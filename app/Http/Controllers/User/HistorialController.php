<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Auth;

class HistorialController extends Controller
{
    /**
     * Muestra el historial completo de solicitudes del aprendiz.
     */
    public function index()
    {
        // Solo mostramos los registros finalizados (Devuelto o Rechazado)
        $prestamos = Prestamo::where('user_id', Auth::id())
            ->whereIn('estado', ['Devuelto', 'Rechazado'])
            ->with(['elemento.categoria'])
            ->orderBy('fecha_devolucion_real', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(8);

        return view('user.historial.index', compact('prestamos'));
    }

    /**
     * Muestra el detalle y seguimiento de un préstamo específico.
     */
    public function show(Prestamo $prestamo)
    {
        // Seguridad: El aprendiz solo puede ver sus propios préstamos
        if ($prestamo->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este préstamo.');
        }

        $prestamo->load(['elemento.categoria']);

        return view('user.historial.show', compact('prestamo'));
    }
}