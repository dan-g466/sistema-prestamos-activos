<x-admin-layout>
    <!-- Header Section -->
    <div class="relative mb-10 px-4 sm:px-0">
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-12 h-12 bg-[#39A900] rounded-2xl flex items-center justify-center shadow-lg shadow-[#39A900]/20 rotate-3 transform hover:rotate-0 transition-all duration-500">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-slate-800 tracking-tighter leading-none">
                            Carga Masiva <span class="text-[#39A900]">SENA</span>
                        </h2>
                        <p class="text-[10px] font-black text-[#39A900] uppercase tracking-[0.4em] mt-1">Gestión de Inventario Digital</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 relative z-10">
                <a href="{{ route('admin.elementos.index') }}" 
                   class="group bg-white border-2 border-[#39A900]/10 text-[#39A900] font-black py-3 px-8 rounded-3xl shadow-sm hover:border-[#39A900] hover:bg-[#39A900] hover:text-white transition-all duration-500 active:scale-95 text-[11px] uppercase tracking-widest flex items-center gap-3">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Regresar</span>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <div class="max-w-7xl mx-auto px-4 sm:px-0" x-data="{ 
        fileName: '', 
        loading: false, 
        globalCategoria: '',
        previewData: [],
        detectCategory(nombre, rowValue) {
            // 1. Si hay valor en el excel, priorizarlo (a menos que sea basura, persona o sin categoría)
            if (rowValue && rowValue.trim()) {
                const rv = rowValue.toLowerCase();
                if (!rv.includes('funcio') && !rv.includes('aprendiz') && !rv.includes('persona') && !rv.includes('sin cate') && !rv.includes('definir')) {
                    return rowValue;
                }
            }

            // 2. Lógica de auto-detección por palabras clave (Igual a ElementoImport.php)
            const n = String(nombre).toLowerCase();
            if (/silla|mesa|escritorio|estante|mueble|tablero|banco|locker|armario|archivador|vitrina|ventilador|aire|estanteria|biblioteca|puesto|atril|biombo|sofa|sillon|perchero|pedestal|pupitre|camarote|cama|repisa/.test(n)) return 'Inmobiliaria';
            if (/computador|laptop|mouse|teclado|monitor|cable|impresora|router|disco|ram|pc|tablet|celular|cámara|parlante|tv|televisor|proyector|videobeam|telon|bafle|ups|regulador|servidor|switch|hub|cargador|adaptador|scanner|camara|webcam|audifonos|toner|tinta/.test(n)) return 'Tecnología';
            if (/papel|esfero|lapiz|cuaderno|marcador|tinta|resma|pegante|tijeras|borrador|grapadora|cosedora|perforadora|cinta|regla|folder|carpeta|legajador|resaltador|bisturi/.test(n)) return 'Papelería';
            if (/balon|pesa|malla|uniforme|raqueta|taco|cronometro|gym|deporte|mancuerna|colchoneta|aro|lazo|pito|peto|pelota/.test(n)) return 'Deportiva';
            
            return 'Sin Categoría';
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            if (!file) {
                this.fileName = '';
                this.previewData = [];
                return;
            }
            this.fileName = file.name;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {type: 'array'});
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                const json = XLSX.utils.sheet_to_json(worksheet);
                
                // Procesar las primeras 5 filas para vista previa
                this.previewData = json.slice(0, 5).map(row => {
                    // Helper para buscar por palabras clave en las llaves del objeto row
                    const findValue = (keywords) => {
                        const key = Object.keys(row).find(k => 
                            keywords.some(kw => k.toLowerCase().includes(kw))
                        );
                        return key ? row[key] : '';
                    };

                    let nombre = findValue(['nombre', 'elemento', 'articulo', 'producto', 'identific']);
                    let descripcion = findValue(['descrip']);
                    let codigo = findValue(['codigo', 'placa', 'inventario', 'sena']);
                    let excelCategoria = findValue(['categ', 'tipo', 'clase', 'grupo']);

                    // Lógica de división igual a ElementoImport.php
                    if (nombre && String(nombre).includes('>>')) {
                        const parts = String(nombre).split('>>');
                        nombre = parts[0].trim();
                        descripcion = parts[1].trim();
                    }

                    return { 
                        nombre, 
                        descripcion, 
                        codigo, 
                        excelCategoria,
                        // Se calculará dinámicamente en el template basado en la selección global
                    };
                });
            };
            reader.readAsArrayBuffer(file);
        }
    }">
        <!-- Error Alerts -->
        @if(session('error') || $errors->any())
            <div class="mb-10 bg-white border-2 border-rose-500 rounded-[2.5rem] p-8 shadow-2xl shadow-rose-500/10 animate-fade-in-down relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-rose-500/5 rounded-bl-full -mr-10 -mt-10"></div>
                <div class="flex items-start gap-6 relative z-10">
                    <div class="bg-rose-500 p-4 rounded-3xl shadow-lg shadow-rose-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xs font-black uppercase tracking-[0.3em] text-slate-800 mb-2">Se detectaron inconvenientes</h4>
                        @if(session('error'))
                            <p class="text-[14px] font-bold text-slate-500 leading-tight">{{ session('error') }}</p>
                        @endif
                        @if($errors->any())
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-2 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li class="text-[13px] font-bold text-slate-500 flex items-center gap-3">
                                        <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Workspace -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Centerpiece: Upload Area -->
            <div class="lg:col-span-8 flex flex-col gap-8">
                <div class="bg-white border-2 border-slate-100 rounded-[4rem] p-12 shadow-2xl shadow-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-64 h-2 bg-[#39A900] rounded-b-full opacity-20"></div>
                    
                    <div class="text-center mb-12">
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-[0.2em] mb-3">Zona de Procesamiento</h3>
                        <p class="text-[12px] text-[#39A900] font-black uppercase tracking-widest bg-[#39A900]/5 inline-block px-6 py-2 rounded-full border border-[#39A900]/10">Formato Permitido: excel (.xlsx, .xls)</p>
                    </div>

                    <form action="{{ route('admin.elementos.import.post') }}" method="POST" enctype="multipart/form-data" @submit="loading = true">
                        @csrf
                        
                        <!-- Premium Category Selector -->
                        <div class="mb-10 animate-fade-in-up" style="animation-delay: 100ms;">
                            <label for="categoria_id" class="block text-[11px] font-black text-[#39A900] uppercase tracking-[0.3em] mb-4 ml-6">
                                1. Asignar Categoría Global (Opcional)
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none transition-transform group-focus-within:scale-110">
                                    <i class="fas fa-tags text-[#39A900]/40 group-focus-within:text-[#39A900]"></i>
                                </div>
                                <select name="categoria_id" id="categoria_id" x-model="globalCategoria" class="block w-full pl-14 pr-12 py-5 bg-slate-50 border-2 border-slate-100 rounded-[2rem] text-sm font-bold text-slate-700 focus:outline-none focus:border-[#39A900] focus:bg-white focus:ring-4 focus:ring-[#39A900]/5 transition-all appearance-none cursor-pointer">
                                    <option value="">Auto-detectar desde el archivo Excel</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none">
                                    <svg class="h-5 h-5 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            <p class="mt-3 ml-6 text-[10px] font-bold text-slate-400">Si seleccionas una, todos los elementos del archivo se guardarán bajo esta categoría.</p>
                        </div>

                        <!-- Upload Area -->
                        <div class="mb-6">
                            <label class="block text-[11px] font-black text-[#39A900] uppercase tracking-[0.3em] mb-4 ml-6">
                                2. Cargar Documento
                            </label>
                            <div class="relative h-64 group animate-fade-in-up" style="animation-delay: 200ms;">
                                <label for="dropzone-file" class="relative flex flex-col items-center justify-center w-full h-full border-[3px] border-[#39A900]/10 border-dashed rounded-[3rem] cursor-pointer bg-slate-50/30 hover:bg-white hover:border-[#39A900] hover:shadow-2xl hover:shadow-[#39A900]/10 transition-all duration-700 overflow-hidden">
                                    
                                    <div class="relative z-10 flex flex-col items-center justify-center p-6 text-center">
                                        <div class="w-20 h-20 bg-white shadow-xl rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-[#39A900] transition-all duration-700 border-2 border-slate-50 group-hover:border-transparent">
                                            <template x-if="!fileName">
                                                <svg class="w-10 h-10 text-[#39A900] group-hover:text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </template>
                                            <template x-if="fileName">
                                                <svg class="w-10 h-10 text-[#39A900] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </template>
                                        </div>

                                        <div x-show="!fileName">
                                            <p class="text-[12px] font-black text-slate-800 uppercase tracking-widest mb-1">Seleccionar Excel</p>
                                            <p class="text-[10px] text-slate-400 font-bold">O arrastra tu archivo</p>
                                        </div>

                                        <div x-show="fileName" class="animate-fade-in-up">
                                            <p class="text-xl font-black text-slate-800 tracking-tighter truncate max-w-[250px] mb-4" x-text="fileName"></p>
                                            <button type="button" @click.prevent="fileName = ''; $refs.fileInput.value = ''" class="text-[10px] font-black text-rose-500 uppercase tracking-widest hover:text-rose-600 transition-colors flex items-center gap-1 mx-auto">
                                                <i class="fas fa-trash-alt"></i> Cambiar
                                            </button>
                                        </div>
                                    </div>
                                    <input id="dropzone-file" name="file" type="file" class="hidden" accept=".xlsx, .xls" @change="handleFileChange($event)" x-ref="fileInput" required />
                                </label>
                            </div>
                        </div>

                        <!-- Data Preview Section -->
                        <div x-show="previewData.length > 0" x-transition class="mb-10 animate-fade-in-up">
                            <div class="flex items-center justify-between mb-4 ml-6">
                                <h4 class="text-[11px] font-black text-[#39A900] uppercase tracking-[0.3em] flex items-center gap-2">
                                    <i class="fas fa-eye"></i> Vista Previa (Primeras 5 filas)
                                </h4>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 px-3 py-1 rounded-full">Automático</span>
                            </div>
                            <div class="bg-slate-50 border-2 border-slate-100 rounded-[2.5rem] overflow-hidden shadow-sm">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr class="bg-slate-100/50">
                                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Nombre del Elemento</th>
                                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Descripción / Detalle</th>
                                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Categoría</th>
                                                <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Código</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(row, index) in previewData" :key="index">
                                                <tr class="border-t border-slate-100 hover:bg-white transition-colors">
                                                    <td class="px-6 py-4">
                                                        <div class="text-[12px] font-bold text-slate-700" x-text="row.nombre"></div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-[12px] font-bold text-slate-500 italic" x-text="row.descripcion || 'Sin descripción detallada'"></div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <template x-if="globalCategoria">
                                                            <span class="px-3 py-1 bg-blue-50 text-[11px] font-black text-blue-600 rounded-full border border-blue-100 uppercase tracking-tighter" x-text="document.getElementById('categoria_id').options[document.getElementById('categoria_id').selectedIndex].text"></span>
                                                        </template>
                                                        <template x-if="!globalCategoria">
                                                            <span class="px-3 py-1 bg-green-50 text-[11px] font-bold text-green-700 rounded-full border border-green-100" x-text="detectCategory(row.nombre, row.excelCategoria)"></span>
                                                        </template>
                                                    </td>
                                                    <td class="px-6 py-4 text-right">
                                                        <span class="text-[12px] font-black text-[#39A900] bg-[#39A900]/5 px-3 py-1 rounded-lg" x-text="row.codigo"></span>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                :disabled="loading || !fileName"
                                class="w-full bg-[#39A900] hover:bg-[#2d8500] text-white font-black py-6 rounded-[2.5rem] shadow-2xl shadow-[#39A900]/30 transition-all duration-700 transform hover:-translate-y-2 active:scale-95 flex items-center justify-center gap-4 disabled:opacity-40 disabled:grayscale disabled:pointer-events-none group overflow-hidden relative">
                            
                            <template x-if="!loading">
                                <div class="flex items-center gap-4 relative z-10 text-lg uppercase tracking-[0.2em]">
                                    <span>Ejecutar Importación</span>
                                    <svg class="w-6 h-6 group-hover:translate-x-3 transition-transform duration-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </div>
                            </template>

                            <template x-if="loading">
                                <div class="flex items-center gap-5 relative z-10 text-lg uppercase tracking-[0.2em]">
                                    <svg class="animate-spin h-7 w-7 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span>Transformando Datos...</span>
                                </div>
                            </template>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Side Column: Instructions & Requirements -->
            <div class="lg:col-span-4 flex flex-col gap-6">
                <!-- Step Card -->
                <div class="bg-white border-2 border-[#39A900] rounded-[3.5rem] p-10 shadow-2xl shadow-[#39A900]/5 flex-1 relative overflow-hidden group">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-[#39A900]/5 rounded-full group-hover:scale-110 transition-transform duration-[2s]"></div>
                    
                    <h4 class="text-[11px] font-black uppercase tracking-[0.4em] text-[#39A900] mb-8 relative z-10 flex items-center gap-3">
                        <span class="w-6 h-0.5 bg-[#39A900]"></span>
                        Requisitos Clave
                    </h4>
                    
                    <div class="space-y-6 relative z-10">
                        <div class="flex items-start gap-4 p-4 rounded-3xl hover:bg-[#39A900]/5 transition-colors duration-500">
                            <div class="bg-[#39A900] text-white w-8 h-8 rounded-xl flex items-center justify-center font-black text-xs shadow-lg shadow-[#39A900]/20">1</div>
                            <div>
                                <h5 class="text-[11px] font-black uppercase tracking-widest text-slate-800 mb-1">Nombre, Código y Descrip.</h5>
                                <p class="text-[12px] font-bold text-slate-500 leading-tight">Columnas recomendadas. Puedes usar ">>" en el nombre para añadir descripción.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 rounded-3xl hover:bg-[#39A900]/5 transition-colors duration-500">
                            <div class="bg-[#39A900] text-white w-8 h-8 rounded-xl flex items-center justify-center font-black text-xs shadow-lg shadow-[#39A900]/20">2</div>
                            <div>
                                <h5 class="text-[11px] font-black uppercase tracking-widest text-slate-800 mb-1">Categorías</h5>
                                <p class="text-[12px] font-bold text-slate-500 leading-tight">Si el nombre no coincide, el sistema creará una nueva.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 rounded-3xl hover:bg-[#39A900]/5 transition-colors duration-500">
                            <div class="bg-[#39A900] text-white w-8 h-8 rounded-xl flex items-center justify-center font-black text-xs shadow-lg shadow-[#39A900]/20">3</div>
                            <div>
                                <h5 class="text-[11px] font-black uppercase tracking-widest text-slate-800 mb-1">Estados Válidos</h5>
                                <p class="text-[12px] font-bold text-slate-500 leading-tight">Disponible, Prestado, En Mantenimiento, Dado de Baja.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 p-6 bg-slate-50 rounded-[2.5rem] border border-slate-100 italic">
                        <span class="text-[10px] font-black text-[#39A900] uppercase tracking-widest block mb-2">Nota Técnica:</span>
                        <p class="text-[12px] font-bold text-slate-400">El sistema actualizará automáticamente los registros que ya existan basados en el código sena.</p>
                    </div>
                </div>

                <!-- SENA Mascot or Graphic Accent -->
                <div class="h-48 bg-gradient-to-br from-[#39A900] to-[#2d8500] rounded-[3rem] p-8 text-white relative overflow-hidden group">
                    <div class="absolute right-0 bottom-0 opacity-10 group-hover:rotate-12 transition-transform duration-700 transform translate-x-4 translate-y-4">
                        <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 14h-1v-4h1v4zm0-6h-1V8h1v2z"/></svg>
                    </div>
                    <div class="relative z-10 flex flex-col justify-end h-full">
                        <h5 class="text-sm font-black uppercase tracking-[0.2em] mb-2">Compromiso SENA</h5>
                        <p class="text-[11px] font-bold text-white/80 leading-snug">Importa tu inventario con total seguridad y rapidez. Tecnología al servicio del aprendizaje.</p>
                        <div class="mt-4 flex gap-1">
                            <div class="w-2 h-2 rounded-full bg-white"></div>
                            <div class="w-10 h-2 rounded-full bg-white/30"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
