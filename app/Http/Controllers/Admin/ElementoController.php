<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Elemento;
use App\Models\Categoria;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ElementoController extends Controller
{
    /**
     * Lista el inventario con filtros dinámicos.
     */
    public function index(Request $request)
    {
        $query = Elemento::with('categoria');

        // Filtro por Búsqueda (Nombre o Código SENA)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('codigo_sena', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por Categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Filtro por Estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $elementos = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $categorias = Categoria::all();
            
        return view('admin.elementos.index', compact('elementos', 'categorias'));
    }

    /**
     * Muestra el formulario de registro de equipo.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.elementos.create', compact('categorias'));
    }

    /**
     * Guarda un nuevo elemento y registra el movimiento inicial.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'codigo_sena' => 'required|string|unique:elementos',
            'categoria_id' => 'required|exists:categorias,id',
            'estado' => 'required|in:Disponible,Prestado,En Mantenimiento,Dado de Baja',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('elementos', 'public');
        }

        $elemento = Elemento::create($data);

        // Registro de Auditoría
        Movimiento::create([
            'elemento_id' => $elemento->id,
            'user_id' => Auth::id(),
            'tipo_movimiento' => 'Entrada',
            'descripcion' => "Registro inicial del equipo en el sistema.",
        ]);

        return redirect()->route('admin.elementos.index')->with('success', 'Elemento registrado e imagen guardada.');
    }

    /**
     * Muestra el detalle de un elemento.
     */
    public function show(Elemento $elemento)
    {
        $elemento->load('categoria');
        return view('admin.elementos.show', compact('elemento'));
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(Elemento $elemento)
    {
        $categorias = Categoria::all();
        return view('admin.elementos.edit', compact('elemento', 'categorias'));
    }

    /**
     * Actualiza el elemento y registra si hubo cambio de estado.
     */
    public function update(Request $request, Elemento $elemento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'codigo_sena' => 'required|string|unique:elementos,codigo_sena,' . $elemento->id,
            'categoria_id' => 'required|exists:categorias,id',
            'estado' => 'required|in:Disponible,Prestado,En Mantenimiento,Dado de Baja',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($elemento->imagen) {
                Storage::disk('public')->delete($elemento->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('elementos', 'public');
        }

        $estadoAnterior = $elemento->estado;
        $elemento->update($data);

        // Si el estado cambió manualmente (ej: a Mantenimiento), registramos el movimiento
        if ($estadoAnterior !== $elemento->estado) {
            Movimiento::create([
                'elemento_id' => $elemento->id,
                'user_id' => Auth::id(),
                'tipo_movimiento' => 'Cambio de Estado',
                'descripcion' => "Estado actualizado manualmente de $estadoAnterior a {$elemento->estado}.",
            ]);
        }

        return redirect()->route('admin.elementos.index')->with('success', 'Elemento actualizado correctamente.');
    }

    /**
     * Elimina el elemento si no tiene historial para no romper la integridad.
     */
    public function destroy(Elemento $elemento)
    {
        // El borrado en cascada (movimientos, préstamos, sanciones) está manejado por los booted() en los Modelos
        $elemento->delete();
        return redirect()->route('admin.elementos.index')->with('success', 'Elemento y su historial han sido eliminados.');
    }
}