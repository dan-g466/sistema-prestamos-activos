<?php

namespace App\Imports;

use App\Models\Elemento;
use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Str;

class ElementoImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $categoria_id;

    public function __construct($categoria_id = null)
    {
        $this->categoria_id = $categoria_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $inputNombre = trim($row['nombre'] ?? '');
        $codigo = trim($row['codigo_sena'] ?? '');

        // Lógica de división: Nombre >> Descripción
        $nombre = $inputNombre;
        $descripcion = trim($row['descripcion'] ?? '');

        if (Str::contains($inputNombre, '>>')) {
            $parts = explode('>>', $inputNombre);
            $nombre = trim($parts[0]);
            $descripcion = trim($parts[1]);
        }

        if (empty($nombre) && empty($codigo)) {
            return null;
        }

        // Determinar la categoría
        if ($this->categoria_id) {
            $categoria_id = $this->categoria_id;
        } else {
            // Buscar o crear la categoría desde el excel
            $categoriaExcel = $row['categoria'] ?? $row['tipo'] ?? $row['clase'] ?? $row['grupo'] ?? null;
            $categoriaNombre = null;

            // Validar que la categoría del excel no sea basura o términos de personas
            if ($categoriaExcel && !Str::contains(strtolower($categoriaExcel), ['funcionario', 'aprendiz', 'persona', 'nombre', 'sin categoria', 'sin categoría', 'por definir'])) {
                $categoriaNombre = trim($categoriaExcel);
            }
            
            if (!$categoriaNombre) {
                // Inteligencia artificial básica para asignar categoría por nombre
                $n = strtolower($nombre);
                
                if (Str::contains($n, ['silla', 'mesa', 'escritorio', 'estante', 'mueble', 'tablero', 'banco', 'locker', 'armario', 'archivador', 'vitrina', 'ventilador', 'aire', 'estanteria', 'biblioteca', 'puesto', 'atril', 'biombo', 'sofa', 'sillon', 'perchero', 'pedestal', 'pupitre', 'locker', 'camarote', 'cama', 'repisa', 'nevera', 'horno', 'modulo', 'estufa', 'cocina', 'congelador', 'lavadora', 'lavamanos', 'purificador', 'camilla', 'dispensador', 'traje', 'extintor', 'taladro', 'balanza', 'herramienta', 'pulidora', 'esmeril', 'compresor', 'soldador', 'careta', 'andamio', 'carretilla', 'pala', 'pico', 'martillo', 'sierra', 'cepillo', 'nivel'])) {
                    $categoriaNombre = 'Inmobiliaria';
                } elseif (Str::contains($n, ['computador', 'laptop', 'mouse', 'teclado', 'monitor', 'cable', 'impresora', 'router', 'disco', 'ram', 'pc', 'tablet', 'celular', 'cámara', 'parlante', 'tv', 'televisor', 'proyector', 'videobeam', 'telon', 'bafle', 'ups', 'regulador', 'servidor', 'switch', 'hub', 'cargador', 'adaptador', 'scanner', 'camara', 'webcam', 'audifonos', 'parlantes', 'toner', 'tinta', 'guitarra', 'organeta', 'organo', 'bajo', 'microfono', 'altavoz', 'mezclador', 'conga', 'sonido', 'radio', 'dvd', 'bateria', 'potencia', 'tensiometro', 'fonendo', 'estetos', 'doppler', 'multimetro', 'osciloscopio', 'generador', 'fuente', 'protoboard', 'arduino', 'raspberry'])) {
                    $categoriaNombre = 'Tecnología';
                } elseif (Str::contains($n, ['papel', 'esfero', 'lapiz', 'cuaderno', 'marcador', 'tinta', 'resma', 'pegante', 'tijeras', 'borrador', 'grapadora', 'cosedora', 'perforadora', 'cinta', 'regla', 'folder', 'carpeta', 'legajador', 'resaltador', 'bisturi', 'pegastick', 'sacapuntas', 'tablero', 'borrador', 'tiza', 'pincel', 'oleo', 'tempera', 'lienzo'])) {
                    $categoriaNombre = 'Papelería';
                } elseif (Str::contains($n, ['balon', 'pesa', 'malla', 'uniforme', 'raqueta', 'taco', 'cronometro', 'gym', 'deporte', 'mancuerna', 'colchoneta', 'aro', 'lazo', 'pito', 'peto', 'pelota', 'bicicleta', 'carpa', 'barra', 'entrenamiento', 'trotadora', 'eliptica', 'baloncesto', 'futbol', 'voley', 'tennis', 'ping pong', 'ajedrez'])) {
                    $categoriaNombre = 'Deportiva';
                } elseif (Str::contains($n, ['licuadora', 'batidora', 'gramera', 'estufa', 'freidora', 'bowl', 'plato', 'vaso', 'cubierto', 'cuchillo', 'olla', 'sarten', 'bandeja', 'molde', 'horno', 'cafetera', 'exprimido', 'wafflera', 'crepera', 'parrilla', 'asador', 'termometro', 'bascula', 'delantal', 'gorro', 'chaqueta chef'])) {
                    $categoriaNombre = 'Gastronomía';
                } elseif (Str::contains($n, ['microscopio', 'tubo ensayo', 'beaker', 'pipeta', 'probeta', 'balanza analitica', 'centrifuga', 'autoclave', 'incubadora', 'agitador', 'phimetro', 'colorimetro', 'espectrofotometro', 'reactivo', 'vidrieria', 'laboratorio'])) {
                    $categoriaNombre = 'Laboratorio';
                } else {
                    $categoriaNombre = 'Sin Categoría';
                }
            }

            $categoria = Categoria::firstOrCreate(['nombre' => trim($categoriaNombre)]);
            $categoria_id = $categoria->id;
        }

        // Mapeo flexible de estados
        $estadoInput = $row['estado'] ?? 'Disponible';
        $estado = match(strtolower(trim($estadoInput))) {
            'disponible' => 'Disponible',
            'prestado', 'prestamo' => 'Prestado',
            'mantenimiento', 'en mantenimiento', 'reparacion' => 'En Mantenimiento',
            'baja', 'dado de baja', 'eliminado' => 'Dado de Baja',
            default => 'Disponible'
        };

        // En lugar de crear un nuevo objeto, buscamos si ya existe para actualizarlo
        $elemento = Elemento::where('codigo_sena', $codigo)->first();
        
        if ($elemento) {
            $elemento->update([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'estado' => $estado,
                'categoria_id' => $categoria_id,
            ]);
            return null; // Retornamos null porque ya lo actualizamos manualmente
        }

        return new Elemento([
            'nombre'       => $nombre,
            'descripcion'  => $descripcion,
            'codigo_sena'  => $codigo,
            'estado'       => $estado,
            'categoria_id' => $categoria_id,
        ]);
    }

    public function rules(): array
    {
        return [
            // Solo requerimos nombre si hay código, y viceversa. 
            // Esto permite saltar filas que no son elementos (como encabezados repetidos o vacíos)
            'nombre' => 'required_with:codigo_sena|string|max:255',
            'codigo_sena' => 'required_with:nombre|string|max:255',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        // Buscamos columnas por palabras clave si no hay un match directo
        foreach ($data as $key => $value) {
            $slugKey = Str::slug($key, '_');
            
            // 1. Mapeo de descripción
            if (empty($data['descripcion']) && Str::contains($slugKey, 'descri')) {
                $data['descripcion'] = $value;
            }

            // 2. Mapeo de nombre
            if (empty($data['nombre']) && (Str::contains($slugKey, 'nombre') || Str::contains($slugKey, 'elemento') || Str::contains($slugKey, 'articulo') || Str::contains($slugKey, 'producto') || Str::contains($slugKey, 'identific'))) {
                $data['nombre'] = $value;
            }

            // 3. Mapeo de código sena
            if (empty($data['codigo_sena']) && (Str::contains($slugKey, 'placa') || Str::contains($slugKey, 'codigo') || Str::contains($slugKey, 'inventario') || Str::contains($slugKey, 'sena'))) {
                $data['codigo_sena'] = $value;
            }

            // 4. Mapeo de categoría
            if (empty($data['categoria']) && (Str::contains($slugKey, 'categ') || Str::contains($slugKey, 'tipo') || Str::contains($slugKey, 'clase') || Str::contains($slugKey, 'grupo'))) {
                $data['categoria'] = $value;
            }
        }

        // FALLBACK: Si no hay nombre pero hay descripción, usamos la descripción como nombre inicial
        if (empty($data['nombre']) && !empty($data['descripcion'])) {
            $data['nombre'] = $data['descripcion'];
        }

        // Valores por defecto finales para compatibilidad
        $data['nombre'] = $data['nombre'] ?? $data['elemento'] ?? null;
        $data['codigo_sena'] = $data['codigo_sena'] ?? $data['placa'] ?? null;
        
        return $data;
    }

    public function customValidationMessages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'codigo_sena.required' => 'El código SENA es obligatorio.',
            'codigo_sena.unique' => 'Este código SENA ya existe en el sistema.',
        ];
    }
}
