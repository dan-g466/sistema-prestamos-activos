<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use App\Models\Elemento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ElementoExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $query = Elemento::query();

        // Aplicar los mismos filtros que en la vista index para que el dashboard de reportes sea coherente
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('codigo_sena', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $totalElementos = $query->count();
        $totalPrestados  = (clone $query)->where('estado', 'Prestado')->count();

        // Tasa de uso
        $usoPorcentaje = $totalElementos > 0
            ? round(($totalPrestados / $totalElementos) * 100, 1)
            : 0;

        // Equipo más solicitado
        $topElemento = (clone $query)->withCount('prestamos')
            ->orderBy('prestamos_count', 'desc')
            ->first();

        // Préstamos retrasados (General)
        $totalVencidos = Prestamo::where('estado', 'Activo')
            ->where('fecha_devolucion_esperada', '<', Carbon::today())
            ->count();

        // Equipos fuera de servicio (filtrados)
        $equiposFuera = (clone $query)->whereIn('estado', ['En Mantenimiento', 'Dado de Baja'])->get();

        return view('admin.reportes.index', compact(
            'usoPorcentaje',
            'topElemento',
            'totalVencidos',
            'equiposFuera'
        ));
    }

    /**
     * Genera un reporte PDF con filtros aplicados.
     */
    public function pdf(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        $tipo = $request->query('tipo', 'inventario');

        if ($tipo === 'inventario') {
            $query = Elemento::with('categoria');

            // Aplicar filtros recibidos
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('codigo_sena', 'LIKE', "%{$search}%");
                });
            }

            if ($request->filled('categoria_id')) {
                $query->where('categoria_id', $request->categoria_id);
            }

            if ($request->filled('estado')) {
                $query->where('estado', $request->estado);
            }

            $elementos = $query->orderBy('nombre')->get();

            $pdf = Pdf::loadView('admin.reportes.pdf-inventario', compact('elementos'))
                      ->setPaper('a4', 'landscape')
                      ->setOptions([
                          'dpi' => 150, 
                          'defaultFont' => 'sans-serif', 
                          'isHtml5ParserEnabled' => true, 
                          'isRemoteEnabled' => true
                      ]);
            
            return $pdf->download('inventario-sena-' . now()->format('Y-m-d') . '.pdf');
        }

        if ($tipo === 'prestamos_mes') {
            $prestamos = Prestamo::with(['user', 'elemento'])
                ->whereMonth('created_at', Carbon::now()->month)
                ->orderBy('created_at', 'desc')
                ->get();
            $pdf = Pdf::loadView('admin.reportes.pdf-prestamos', compact('prestamos'))
                      ->setPaper('a4', 'portrait')
                      ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            return $pdf->download('prestamos-' . now()->format('Y-m') . '.pdf');
        }

        abort(404, 'Tipo de reporte no válido.');
    }

    /**
     * Exporta el inventario filtrado a Excel.
     */
    public function excel(Request $request)
    {
        return Excel::download(new ElementoExport($request), 'inventario-sena-' . now()->format('Y-m-d') . '.xlsx');
    }
}