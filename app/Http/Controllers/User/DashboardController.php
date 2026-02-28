<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use App\Models\Sancion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Solicitudes en trámite (Pendiente o Aceptado)
        $solicitudes = Prestamo::where('user_id', $userId)
            ->whereIn('estado', ['Pendiente', 'Aceptado'])
            ->with('elemento.categoria')
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Préstamos que ya tiene físicamente (Activo o Vencido)
        $prestamosActivos = Prestamo::where('user_id', $userId)
            ->whereIn('estado', ['Activo', 'Vencido'])
            ->with('elemento.categoria')
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Verificar si tiene alguna sanción vigente (HU-US-10)
        $sancionActiva = Sancion::where('user_id', $userId)
            ->where('estado', 'Activa')
            ->where('fecha_fin', '>=', Carbon::today())
            ->first();

        // 3. Notificaciones no leídas
        $notificaciones = Auth::user()->unreadNotifications;

        return view('user.dashboard', compact('prestamosActivos', 'solicitudes', 'sancionActiva', 'notificaciones'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('success', 'Notificación marcada como leída.');
    }
}