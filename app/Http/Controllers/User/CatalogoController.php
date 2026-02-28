<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Elemento;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        // Filtrar solo elementos con estado 'Disponible'
        $query = Elemento::where('estado', 'Disponible')->with('categoria');

        // Búsqueda opcional por nombre o código
        if ($request->filled('search')) {
            $query->where('nombre', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('codigo_sena', 'LIKE', '%' . $request->search . '%');
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        $elementos = $query->paginate(12);
        $categorias = Categoria::all();

        return view('user.catalogo.index', compact('elementos', 'categorias'));
    }
}