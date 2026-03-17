<x-admin-layout>
    <!-- Header Premium -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-[#39A900] transition-colors">Panel</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Auditoría & Sistemas</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-2xl font-black text-[#00324D] dark:text-white tracking-tight">
                    Carga Masiva de <span class="text-[#39A900]">Inventario</span>
                </h2>
                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest flex items-center gap-2 mt-1">
                    <span class="w-2 h-2 rounded-full bg-[#39A900]"></span>
                    Procesamiento de Archivos Digitales
                </p>
            </div>
            
            <a href="{{ route('admin.elementos.index') }}" 
               class="flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-[#00324D] dark:hover:text-white transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Ver Inventario
            </a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <div class="max-w-7xl mx-auto" x-data="{ 
        fileName: '', 
        loading: false, 
        globalCategoria: '',
        previewData: [],
        detectCategory(nombre, rowValue) {
            if (rowValue && rowValue.trim()) {
                const rv = rowValue.toLowerCase();
                if (!rv.includes('funcio') && !rv.includes('aprendiz') && !rv.includes('persona') && !rv.includes('sin cate') && !rv.includes('definir')) {
                    return rowValue;
                }
            }
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
                this.previewData = json.slice(0, 5).map(row => {
                    const findValue = (keywords) => {
                        const key = Object.keys(row).find(k => keywords.some(kw => k.toLowerCase().includes(kw)));
                        return key ? row[key] : '';
                    };
                    let nombre = findValue(['nombre', 'elemento', 'articulo', 'producto', 'identific']);
                    let descripcion = findValue(['descrip']);
                    let codigo = findValue(['codigo', 'placa', 'inventario', 'sena']);
                    let excelCategoria = findValue(['categ', 'tipo', 'clase', 'grupo']);
                    if (nombre && String(nombre).includes('>>')) {
                        const parts = String(nombre).split('>>');
                        nombre = parts[0].trim();
                        descripcion = parts[1].trim();
                    }
                    return { nombre, descripcion, codigo, excelCategoria };
                });
            };
            reader.readAsArrayBuffer(file);
        }
    }">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left Panel: Form and Upload -->
            <div class="lg:col-span-8 space-y-6">
                
                @if(session('error') || $errors->any())
                    <div class="bg-rose-50 dark:bg-rose-900/10 border border-rose-200 dark:border-rose-900/30 p-4 rounded-2xl animate-fade-in-down">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-rose-500 rounded-lg shadow-lg shadow-rose-500/20">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-rose-600 dark:text-rose-400">Inconsistencias Detectadas</h4>
                        </div>
                        <ul class="space-y-1 ml-11">
                            @foreach ($errors->all() as $error)
                                <li class="text-[11px] font-bold text-rose-500/80 dark:text-rose-400/80">• {{ $error }}</li>
                            @endforeach
                            @if(session('error'))
                                <li class="text-[11px] font-bold text-rose-500/80 dark:text-rose-400/80">• {{ session('error') }}</li>
                            @endif
                        </ul>
                    </div>
                @endif

                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2.5rem] p-6 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#39A900]/5 rounded-bl-full -mr-10 -mt-10"></div>
                    
                    <form action="{{ route('admin.elementos.import.post') }}" method="POST" enctype="multipart/form-data" @submit="loading = true">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Category Assign -->
                            <div class="space-y-2">
                                <label for="categoria_id" class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Asignación Directa</label>
                                <div class="relative group">
                                    <select name="categoria_id" id="categoria_id" x-model="globalCategoria" class="w-full pl-4 pr-10 py-3 bg-slate-50 dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-700 rounded-2xl text-xs font-bold text-slate-700 dark:text-white focus:outline-none focus:border-[#39A900] transition-all appearance-none cursor-pointer">
                                        <option value="">Detectar Automáticamente</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- File Info -->
                            <div class="space-y-2">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Estado del Archivo</label>
                                <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-700 rounded-2xl px-4 py-3 h-[50px]">
                                    <template x-if="!fileName">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-slate-300 animate-pulse"></div>
                                            <span class="text-[10px] font-black text-slate-400 tracking-widest uppercase">Esperando Selección</span>
                                        </div>
                                    </template>
                                    <template x-if="fileName">
                                        <div class="flex items-center justify-between w-full">
                                            <span class="text-[10px] font-black text-[#39A900] truncate max-w-[150px]" x-text="fileName"></span>
                                            <button type="button" @click="fileName = ''; previewData = []; $refs.fileInput.value = ''" class="text-[8px] font-black text-rose-500 uppercase tracking-widest hover:bg-rose-50 px-2 py-1 rounded-lg transition-colors">Remover</button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Dropzone Area -->
                        <div class="mb-8">
                            <label for="dropzone-file" class="group relative flex flex-col items-center justify-center w-full h-48 border-2 border-slate-100 dark:border-slate-800 border-dashed rounded-[2rem] cursor-pointer bg-slate-50/50 dark:bg-slate-800/30 hover:border-[#39A900] transition-all duration-500 overflow-hidden">
                                <div class="relative z-10 flex flex-col items-center pointer-events-none">
                                    <div class="w-16 h-16 bg-white dark:bg-slate-900 rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 mb-4">
                                        <svg class="w-8 h-8 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <p class="text-[11px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-widest">Suelte el archivo aquí</p>
                                    <p class="text-[9px] text-slate-400 font-bold mt-1">Excel .xlsx o .xls (Máx. 100MB)</p>
                                </div>
                                <input id="dropzone-file" name="file" type="file" class="hidden" accept=".xlsx, .xls" @change="handleFileChange($event)" x-ref="fileInput" required />
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                :disabled="loading || !fileName"
                                class="w-full flex items-center justify-center gap-3 py-4 bg-[#39A900] hover:bg-[#2d8500] text-white font-black rounded-2xl shadow-xl shadow-[#39A900]/20 transition-all active:scale-95 disabled:opacity-50 disabled:grayscale group">
                            <template x-if="!loading">
                                <span class="flex items-center gap-3 text-xs uppercase tracking-[0.2em]">
                                    Procesar Carga Masiva
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </span>
                            </template>
                            <template x-if="loading">
                                <span class="flex items-center gap-3 text-xs uppercase tracking-[0.2em]">
                                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Sincronizando...
                                </span>
                            </template>
                        </button>
                    </form>
                </div>

                <!-- Preview Table Card -->
                <div x-show="previewData.length > 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
                        <h4 class="text-[10px] font-black text-[#00324D] dark:text-white uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#39A900]"></span>
                            Vista Previa de Datos
                        </h4>
                        <span class="text-[8px] font-black text-[#39A900] bg-[#39A900]/10 px-2 py-0.5 rounded-full uppercase tracking-widest ring-1 ring-[#39A900]/20">Primeros 5 registros</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-[8px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/30 dark:bg-slate-900/30">
                                    <th class="px-6 py-3">Elemento</th>
                                    <th class="px-6 py-3">Referencia</th>
                                    <th class="px-6 py-3">Categoría Asignada</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                <template x-for="(row, index) in previewData" :key="index">
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="text-[11px] font-bold text-slate-700 dark:text-white" x-text="row.nombre"></div>
                                            <div class="text-[9px] text-slate-400 font-medium italic truncate max-w-[200px]" x-text="row.descripcion || 'Sin descripción'"></div>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-[10px] font-black text-[#39A900]" x-text="row.codigo"></td>
                                        <td class="px-6 py-4">
                                            <template x-if="globalCategoria">
                                                <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 text-[9px] font-black rounded-lg border border-blue-100 dark:border-blue-800 uppercase tracking-tighter" x-text="document.getElementById('categoria_id').options[document.getElementById('categoria_id').selectedIndex].text"></span>
                                            </template>
                                            <template x-if="!globalCategoria">
                                                <span class="px-2 py-0.5 bg-[#39A900]/10 text-[#39A900] text-[9px] font-black rounded-lg border border-[#39A900]/20 uppercase tracking-tighter" x-text="detectCategory(row.nombre, row.excelCategoria)"></span>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Guide & Template -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Template Download Card -->
                <div class="bg-[#00324D] rounded-[2.5rem] p-8 text-white relative overflow-hidden group shadow-xl">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:rotate-12 transition-transform duration-1000">
                        <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 14h-1v-4h1v4zm0-6h-1V8h1v2z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h4 class="text-xs font-black uppercase tracking-widest">Recurso de Apoyo</h4>
                        </div>
                        <p class="text-xs font-bold text-white/70 leading-relaxed mb-6">Utilice nuestra plantilla oficial para garantizar que el sistema procese correctamente sus activos.</p>
                        <button type="button" @click="
                            const ws = XLSX.utils.aoa_to_sheet([
                                ['NOMBRE', 'CODIGO_SENA', 'DESCRIPCION', 'CATEGORIA', 'ESTADO'],
                                ['Silla Ergonómica SENA', '1234567', 'Color negro con ruedas', 'Inmobiliaria', 'Disponible'],
                                ['Computador Portátil HP', '7891011', '16GB RAM, SSD 512GB', 'Tecnología', 'Prestado']
                            ]);
                            const wb = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(wb, ws, 'Elementos');
                            XLSX.writeFile(wb, 'Plantilla_SENA_Inventario.xlsx');
                        " class="w-full flex items-center justify-between px-6 py-3 bg-[#39A900] hover:bg-white hover:text-[#00324D] rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95 group/btn">
                            Descargar Plantilla
                            <svg class="w-4 h-4 group-hover/btn:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Technical Guide Card -->
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2.5rem] p-8 shadow-sm">
                    <h4 class="text-[10px] font-black text-[#00324D] dark:text-white uppercase tracking-[0.3em] mb-8 flex items-center gap-2">
                        <span class="p-1.5 bg-[#39A900]/10 rounded-lg">
                            <svg class="w-3.5 h-3.5 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        Lineamientos Técnicos
                    </h4>

                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-6 h-6 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center text-[10px] font-black text-[#00324D] dark:text-[#39A900]">01</div>
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 leading-snug">El <span class="text-[#00324D] dark:text-white">Código SENA</span> debe ser único. Si el código ya existe, el sistema actualizará la información del elemento automáticamente.</p>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-6 h-6 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center text-[10px] font-black text-[#00324D] dark:text-[#39A900]">02</div>
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 leading-snug">Si deja vacía la <span class="text-[#00324D] dark:text-white">Categoría</span>, nuestro algoritmo de IA intentará clasificarlo según su nombre.</p>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-6 h-6 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center text-[10px] font-black text-[#00324D] dark:text-[#39A900]">03</div>
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 leading-snug">Estados válidos: <span class="px-1.5 py-0.5 bg-green-50 dark:bg-green-900/10 text-green-600 rounded text-[9px]">Disponible</span>, <span class="px-1.5 py-0.5 bg-blue-50 dark:bg-blue-900/10 text-blue-600 rounded text-[9px]">Prestado</span>, <span class="px-1.5 py-0.5 bg-amber-50 dark:bg-amber-900/10 text-amber-600 rounded text-[9px]">Mantenimiento</span>.</p>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-50 dark:border-slate-800 flex items-center gap-3">
                        <div class="h-10 w-10 flex-shrink-0 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center">
                            <img src="{{ asset('img/logo sena.png') }}" class="h-6 w-auto grayscale opacity-50">
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Sistema de Gestión</p>
                            <p class="text-[10px] font-black text-[#39A900] uppercase tracking-tighter">Auditoría Digital 2026</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('duplicate_db_alert'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Base de Datos Existente',
                    text: '{{ session('duplicate_db_alert') }}',
                    icon: 'info',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#39A900',
                    customClass: {
                        confirmButton: 'swal2-confirm',
                    }
                });
            });
        </script>
    @endif
</x-admin-layout>
