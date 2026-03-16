<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Muestra el registro de auditoría con filtros funcionales.
     */
    public function index(Request $request)
    {
        $query = Movimiento::with(['elemento', 'user']);

        // Filtro por Fecha
        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }

        // Filtro por Tipo de Movimiento
        if ($request->filled('tipo')) {
            $query->where('tipo_movimiento', $request->tipo);
        }

        // Filtro por Búsqueda (Nombre del equipo o Placa SENA)
        if ($request->filled('buscar')) {
            $query->whereHas('elemento', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->buscar . '%')
                  ->orWhere('codigo_sena', 'like', '%' . $request->buscar . '%');
            });
        }

        $movimientos = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.movimientos.index', compact('movimientos'));
    }

    /**
     * Ver el detalle completo de un movimiento específico.
     */
    public function show(Movimiento $movimiento)
    {
        $movimiento->load(['elemento', 'user']);
        return view('admin.movimientos.show', compact('movimiento'));
    }

    /**
     * Historial de un elemento específico (Útil para ver la "hoja de vida" de un equipo).
     */
    public function showByElemento($elementoId)
    {
        $movimientos = Movimiento::where('elemento_id', $elementoId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.movimientos.elemento_history', compact('movimientos'));
    }
}