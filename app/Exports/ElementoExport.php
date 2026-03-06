<?php

namespace App\Exports;

use App\Models\Elemento;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ElementoExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Elemento::query()->with('categoria');

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('codigo_sena', 'LIKE', "%{$search}%");
            });
        }

        if ($this->request->filled('categoria_id')) {
            $query->where('categoria_id', $this->request->categoria_id);
        }

        if ($this->request->filled('estado')) {
            $query->where('estado', $this->request->estado);
        }

        return $query->orderBy('nombre');
    }

    public function title(): string
    {
        return 'Inventario Elements';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Código SENA',
            'Nombre',
            'Categoría',
            'Estado',
            'Descripción',
            'Fecha Registro',
        ];
    }

    public function map($elemento): array
    {
        return [
            $elemento->id,
            $elemento->codigo_sena,
            $elemento->nombre,
            $elemento->categoria->nombre ?? 'N/A',
            $elemento->estado,
            $elemento->descripcion,
            $elemento->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '39A900']]],
        ];
    }
}
