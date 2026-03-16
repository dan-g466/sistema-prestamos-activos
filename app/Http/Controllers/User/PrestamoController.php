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
            ->whereIn('estado', ['Pendiente', 'Aceptado', 'Por Confirmar'])
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

        // 0. Validar si el usuario está sancionado (Seguridad del lado del servidor)
        if ($user->estaSancionado()) {
            $sancion = $user->obtenerSancionActiva();
            $motivo = $sancion ? " debido a: '{$sancion->motivo}'" : "";
            return redirect()->back()->with('error', "Tu cuenta se encuentra bloqueada por una sanción activa{$motivo}. No puedes solicitar equipos.");
        }

        return \DB::transaction(function () use ($request, $user) {
            $elemento = Elemento::where('id', $request->elemento_id)
                ->lockForUpdate()
                ->firstOrFail();

            // 1. Verificar disponibilidad real
            if ($elemento->estado !== 'Disponible') {
                return redirect()->back()->with('error', 'Lo sentimos, este equipo ya no se encuentra disponible.');
            }

            // 2. Evitar solicitudes duplicadas simultáneas
            $existe = Prestamo::where('user_id', $user->id)
                ->where('elemento_id', $elemento->id)
                ->whereIn('estado', ['Pendiente', 'Aceptado', 'Activo', 'Por Confirmar'])
                ->exists();

            if ($existe) {
                return redirect()->back()->with('error', 'Ya tienes una solicitud activa para este equipo.');
            }

            // 3. Crear el préstamo
            $prestamo = Prestamo::create([
                'user_id' => $user->id,
                'elemento_id' => $elemento->id,
                'fecha_solicitud' => now(),
                'fecha_inicio' => \Carbon\Carbon::parse($request->fecha_inicio),
                'fecha_devolucion_esperada' => \Carbon\Carbon::parse($request->fecha_devolucion_esperada),
                'estado' => 'Pendiente',
                'observaciones' => $request->observaciones,
            ]);

            // 4. Marcar equipo como prestado inmediatamente
            $elemento->update(['estado' => 'Prestado']);

            // 5. Notificar a los administradores
            $admins = \App\Models\User::role('Lider Admin')->get();
            $mensajeAdmin = "Nueva solicitud de préstamo del aprendiz {$user->name} para el equipo '{$elemento->nombre}'. Ingresa a préstamos para revisarla.";
            foreach($admins as $admin) {
                $admin->notify(new \App\Notifications\PrestamoStatusUpdated($prestamo, $mensajeAdmin));
            }

            return redirect()->route('user.prestamos.index')->with('success', '¡Solicitud enviada con éxito! Puedes ver el estado de tu trámite aquí.');
        });
    }
}