<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Elemento;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestamoController extends Controller
{
    // Mostrar solicitudes (Pendiente, Aceptado)
    public function solicitudes()
    {
        $prestamos = Prestamo::where('user_id', Auth::id())
            ->whereIn('estado', ['Pendiente', 'Aceptado'])
            ->with(['elemento.categoria'])
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('user.prestamos.index', compact('prestamos'));
    }

    // Mostrar préstamos en curso (Activo, Vencido)
    public function activos()
    {
        $prestamos = Prestamo::where('user_id', Auth::id())
            ->whereIn('estado', ['Activo', 'Vencido'])
            ->with(['elemento.categoria'])
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('user.prestamos.activos', compact('prestamos'));
    }

    // Mostrar catálogo (mantenido por compatibilidad si se usa aquí)
    public function catalogo()
    {
        $elementos = Elemento::where('estado', 'Disponible')->with('categoria')->paginate(12);
        return view('user.catalogo.index', compact('elementos'));
    }

    // Procesar la solicitud de préstamo
    public function store(Request $request)
    {
        // Valores por defecto si faltan
        if (!$request->has('fecha_inicio') || empty($request->fecha_inicio)) {
            $request->merge(['fecha_inicio' => now()->addMinutes(15)->format('Y-m-d\TH:i')]);
        }
        if (!$request->has('fecha_devolucion_esperada') || empty($request->fecha_devolucion_esperada)) {
            // Por defecto 4 horas después del inicio
            $inicio = \Carbon\Carbon::parse($request->fecha_inicio);
            $request->merge(['fecha_devolucion_esperada' => $inicio->addHours(4)->format('Y-m-d\TH:i')]);
        }

        $request->validate([
            'elemento_id' => 'required|exists:elementos,id',
            'fecha_inicio' => 'required|date',
            'fecha_devolucion_esperada' => 'required|date|after:fecha_inicio',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'fecha_devolucion_esperada.after' => 'La fecha de devolución (Hasta) debe ser posterior a la fecha de inicio (Desde).',
        ]);

        $user = Auth::user();
        $elemento = Elemento::findOrFail($request->elemento_id);

        Prestamo::create([
            'user_id' => $user->id,
            'elemento_id' => $elemento->id,
            'fecha_solicitud' => now(),
            'fecha_inicio' => \Carbon\Carbon::parse($request->fecha_inicio),
            'fecha_devolucion_esperada' => \Carbon\Carbon::parse($request->fecha_devolucion_esperada),
            'estado' => 'Pendiente',
            'observaciones' => $request->observaciones,
        ]);

        // Marcar equipo como prestado inmediatamente para que no aparezca en el catálogo (HU-LU-01)
        $elemento->update(['estado' => 'Prestado']);

        return redirect()->back()->with('success', '¡Solicitud enviada con éxito! Revisa tu Panel para ver el estado.');
    }
}