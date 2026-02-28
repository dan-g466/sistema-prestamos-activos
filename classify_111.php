<?php

use App\Models\Elemento;
use App\Models\Categoria;
use Illuminate\Support\Str;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$categorias = Categoria::pluck('id', 'nombre')->toArray();

$keywords = [
    'Inmobiliaria' => ['silla', 'mesa', 'escritorio', 'estante', 'mueble', 'tablero', 'banco', 'locker', 'armario', 'archivador', 'vitrina', 'ventilador', 'aire', 'estanteria', 'biblioteca', 'puesto', 'atril', 'biombo', 'sofa', 'sillon', 'perchero', 'pedestal', 'pupitre', 'locker', 'camarote', 'cama', 'repisa', 'nevera', 'horno', 'modulo', 'estufa', 'cocina', 'congelador', 'lavadora', 'lavamanos', 'purificador', 'camilla', 'dispensador', 'traje', 'extintor', 'taladro', 'balanza', 'herramienta'],
    'Tecnología' => ['computador', 'laptop', 'mouse', 'teclado', 'monitor', 'cable', 'impresora', 'router', 'disco', 'ram', 'pc', 'tablet', 'celular', 'cámara', 'parlante', 'tv', 'televisor', 'proyector', 'videobeam', 'telon', 'bafle', 'ups', 'regulador', 'servidor', 'switch', 'hub', 'cargador', 'adaptador', 'scanner', 'camara', 'webcam', 'audifonos', 'parlantes', 'toner', 'tinta', 'guitarra', 'organeta', 'organo', 'bajo', 'microfono', 'altavoz', 'mezclador', 'conga', 'sonido', 'radio', 'dvd', 'bateria', 'potencia', 'tensiometro', 'fonendo', 'estetos', 'doppler'],
    'Papelería' => ['papel', 'esfero', 'lapiz', 'cuaderno', 'marcador', 'tinta', 'resma', 'pegante', 'tijeras', 'borrador', 'grapadora', 'cosedora', 'perforadora', 'cinta', 'regla', 'folder', 'carpeta', 'legajador', 'resaltador', 'bisturi'],
    'Deportiva' => ['balon', 'pesa', 'malla', 'uniforme', 'raqueta', 'taco', 'cronometro', 'gym', 'deporte', 'mancuerna', 'colchoneta', 'aro', 'lazo', 'pito', 'peto', 'pelota', 'bicicleta', 'carpa', 'barra', 'entrenamiento', 'trotadora', 'eliptica']
];

$elementos = Elemento::all();
$count = 0;

foreach ($elementos as $elemento) {
    if ($elemento->categoria_id != 36) continue; // Solo los Sin Categoría

    $n = strtolower($elemento->nombre . ' ' . $elemento->descripcion);
    
    foreach ($keywords as $catName => $words) {
        if (Str::contains($n, $words)) {
            if (isset($categorias[$catName])) {
                $elemento->categoria_id = $categorias[$catName];
                $elemento->save();
                echo "Re-asignado: [{$elemento->nombre}] -> {$catName}\n";
                $count++;
                break;
            }
        }
    }
}

echo "\nTotal re-clasificados: $count\n";
