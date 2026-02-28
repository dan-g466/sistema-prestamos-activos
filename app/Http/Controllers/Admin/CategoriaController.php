<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categorias = Categoria::query()
            ->when($search, function ($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%")
                             ->orWhere('descripcion', 'like', "%{$search}%");
            })
            ->orderBy('nombre', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias',
            'descripcion' => 'nullable|string'
        ]);

        Categoria::create($request->all());
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string'
        ]);

        $categoria->update($request->all());
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(Categoria $categoria)
    {
        // El borrado en cascada (elementos, movimientos, préstamos) está manejado por los booted() en los Modelos
        $categoria->delete();
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría y todos sus elementos vinculados han sido eliminados.');
    }
}