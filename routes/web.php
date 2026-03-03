<?php

use Illuminate\Support\Facades\Route;

// Controladores de Perfil y General
use App\Http\Controllers\ProfileController;

// Controladores del LÍDER ADMIN
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ElementoController;
use App\Http\Controllers\Admin\PrestamoController as AdminPrestamo;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\MovimientoController;
use App\Http\Controllers\Admin\SancionController as AdminSancion;
use App\Http\Controllers\Admin\ElementoImportController;

// Controladores del USUARIO SENA (Aprendiz)
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\CatalogoController;
use App\Http\Controllers\User\PrestamoController as UserPrestamo;
use App\Http\Controllers\User\HistorialController;
use App\Http\Controllers\User\SancionController as UserSancion;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

/**
 * RUTAS PARA EL LÍDER ADMIN
 * Acceso restringido mediante Middleware de Rol
 */
Route::middleware(['auth', 'role:Lider Admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard Principal
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // 2. Gestión de Inventario
    Route::resource('categorias', CategoriaController::class);
    Route::resource('elementos', ElementoController::class);
    Route::get('/elementos-importar', [ElementoImportController::class, 'showImportForm'])->name('elementos.import');
    Route::post('/elementos-importar', [ElementoImportController::class, 'import'])->name('elementos.import.post');

    // 3. Gestión Operativa de Préstamos
    // Importante: Vencidos debe ir antes del resource para evitar conflictos de ID
    Route::get('/prestamos/vencidos', [AdminPrestamo::class, 'vencidos'])->name('prestamos.vencidos');
    Route::resource('prestamos', AdminPrestamo::class);
    
    // Acciones de flujo de trabajo
    Route::post('/prestamos/{prestamo}/aceptar', [AdminPrestamo::class, 'aceptar'])->name('prestamos.aceptar');
    Route::post('/prestamos/{prestamo}/entregar', [AdminPrestamo::class, 'entregar'])->name('prestamos.entregar');
    Route::post('/prestamos/{prestamo}/rechazar', [AdminPrestamo::class, 'rechazar'])->name('prestamos.rechazar');
    Route::post('/prestamos/{prestamo}/finalizar', [AdminPrestamo::class, 'finalizar'])->name('prestamos.finalizar');
    Route::post('/prestamos/{prestamo}/confirmar', [AdminPrestamo::class, 'confirmarDevolucion'])->name('prestamos.confirmar');

    // 4. Gestión de Usuarios y Sanciones
    Route::resource('usuarios', UserController::class)
        ->except(['create', 'store'])
        ->parameters(['usuarios' => 'user']);
    Route::resource('sanciones', AdminSancion::class)
        ->except(['show'])
        ->parameters(['sanciones' => 'sancion']);

    // 5. Reportes y Auditoría
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/pdf', [ReporteController::class, 'pdf'])->name('reportes.pdf');

    Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');
    
    // 6. Sistema de Seguridad y Backups
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::get('/backups/generar', [BackupController::class, 'create'])->name('backups.create');
    Route::get('/backups/download/{fileName}', [BackupController::class, 'download'])->name('backups.download');
    Route::delete('/backups/delete/{fileName}', [BackupController::class, 'destroy'])->name('backups.destroy');
    Route::get('/backups/upload', [BackupController::class, 'upload'])->name('backups.upload');
    Route::post('/backups/restore', [BackupController::class, 'restore'])->name('backups.restore');
});

/**
 * RUTAS PARA EL USUARIO SENA (Aprendiz)
 * Acceso para consulta, catálogo y control personal
 */
Route::middleware(['auth', 'role:Usuario SENA'])->prefix('usuario')->name('user.')->group(function () {
    
    // Dashboard y Notificaciones
    Route::get('/panel', [UserDashboard::class, 'index'])->name('dashboard');
    Route::post('/notificaciones/{id}/leer', [UserDashboard::class, 'markAsRead'])->name('notificaciones.leer');

    // Catálogo y Solicitudes
    Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');
    Route::post('/solicitar', [UserPrestamo::class, 'store'])->name('solicitar');
    Route::get('/mis-solicitudes', [UserPrestamo::class, 'solicitudes'])->name('prestamos.index');
    Route::get('/prestamos-activos', [UserPrestamo::class, 'activos'])->name('prestamos.activos');
    Route::get('/prestamo/{prestamo}', [HistorialController::class, 'show'])->name('prestamos.show');

    // Historial y Sanciones Propias
    Route::get('/historial', [HistorialController::class, 'index'])->name('historial');
    Route::get('/mis-sanciones', [UserSancion::class, 'index'])->name('sanciones.index');
});

/**
 * RUTAS DE PERFIL (Comunes)
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';