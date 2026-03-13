<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ElementoImport;
use App\Models\Categoria;
use Maatwebsite\Excel\Facades\Excel;

class ElementoImportController extends Controller
{
    public function showImportForm()
    {
        $categorias = Categoria::all();
        return view('admin.elementos.import', compact('categorias'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:102400', // Permitimos hasta 100MB
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        try {
            Excel::import(new ElementoImport($request->categoria_id), $request->file('file'));
            return redirect()->route('admin.elementos.index')
                ->with('success', 'Elementos importados correctamente.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Error en la fila {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return back()->withErrors($errors)->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al importar el archivo: ' . $e->getMessage());
        }
    }
}
