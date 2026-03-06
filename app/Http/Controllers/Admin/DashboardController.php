<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Elemento;
use App\Models\Prestamo;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas para el Sistema de Préstamos
        $totalElementos = Elemento::count();
        $prestamosPendientes = Prestamo::where('estado', 'Pendiente')->count();
        $prestamosActivos = Prestamo::where('estado', 'Activo')->count();
        $usuariosSancionados = User::where('sancionado', true)->count();

        // CAMBIO: Ahora busca resources/views/admin/dashboard.blade.php
        return view('admin.dashboard', compact(
            'totalElementos', 
            'prestamosPendientes', 
            'prestamosActivos', 
            'usuariosSancionados'
        ));
    }
}