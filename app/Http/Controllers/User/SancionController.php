<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sancion;
use Illuminate\Support\Facades\Auth;

class SancionController extends Controller
{
    /**
     * Muestra el historial de sanciones del aprendiz autenticado.
     */
    public function index()
    {
        // Obtenemos las sanciones cargando la relación del préstamo y el elemento
        // para que el aprendiz sepa exactamente por qué equipo fue sancionado.
        $sanciones = Sancion::where('user_id', Auth::id())
            ->with(['prestamo.elemento'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Referencia a la carpeta organizada: resources/views/user/sanciones/index.blade.php
        return view('user.sanciones.index', compact('sanciones'));
    }
}