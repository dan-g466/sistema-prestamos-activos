<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use App\Models\Elemento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
        $totalElementos = Elemento::count();
        $totalPrestados  = Elemento::where('estado', 'Prestado')->count();

        // Tasa de uso (% de equipos fuera de bodega)
        $usoPorcentaje = $totalElementos > 0
            ? round(($totalPrestados / $totalElementos) * 100, 1)
            : 0;

        // Equipo más solicitado
        $topElemento = Elemento::withCount('prestamos')
            ->orderBy('prestamos_count', 'desc')
            ->first();

        // Préstamos retrasados (activos con fecha pasada)
        $totalVencidos = Prestamo::where('estado', 'Activo')
            ->where('fecha_devolucion_esperada', '<', Carbon::today())
            ->count();

        // Equipos fuera de servicio
        $equiposFuera = Elemento::whereIn('estado', ['En Mantenimiento', 'Dado de Baja'])->get();

        return view('admin.reportes.index', compact(
            'usoPorcentaje',
            'topElemento',
            'totalVencidos',
            'equiposFuera'
        ));
    }

    /**
     * Genera un reporte en texto plano (placeholder para PDF futuro).
     */
    public function pdf(Request $request)
    {
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', '120');

        $tipo = $request->query('tipo', 'inventario');

        if ($tipo === 'inventario') {
            $elementos = Elemento::with('categoria')->orderBy('nombre')->get();
            $pdf = Pdf::loadView('admin.reportes.pdf-inventario', compact('elementos'))
                      ->setPaper('a4', 'landscape')
                      ->setOptions(['dpi' => 72, 'defaultFont' => 'serif', 'enable_javascript' => false]);
            return $pdf->download('inventario-sena-' . now()->format('Y-m-d') . '.pdf');
        }

        if ($tipo === 'prestamos_mes') {
            $prestamos = Prestamo::with(['user', 'elemento'])
                ->whereMonth('created_at', Carbon::now()->month)
                ->orderBy('created_at', 'desc')
                ->get();
            $pdf = Pdf::loadView('admin.reportes.pdf-prestamos', compact('prestamos'))
                      ->setPaper('a4', 'portrait')
                      ->setOptions(['dpi' => 72, 'defaultFont' => 'serif', 'enable_javascript' => false]);
            return $pdf->download('prestamos-' . now()->format('Y-m') . '.pdf');
        }

        abort(404, 'Tipo de reporte no válido.');
    }
}