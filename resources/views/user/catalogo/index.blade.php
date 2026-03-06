<x-user-layout>

    <div x-data="{ 
        openModal: false, 
        submitting: false,
        elementoId: null, 
        elementoNombre: '',
        init() {
            console.log('Catálogo iniciado');
        }
    }">

        {{-- ─── Hero / Search Bar ─── --}}
        <div class="bg-[#39A900] py-10 px-4 rounded-3xl mb-8 shadow-lg shadow-green-900/20">
            <div class="max-w-5xl mx-auto text-center">
                <p class="text-[10px] font-black text-white/50 uppercase tracking-[0.3em] mb-1">Centro de Gestión</p>
                <h1 class="text-2xl md:text-3xl font-black text-white mb-6 tracking-tight">
                    Catálogo de <span class="text-[#ffffff]">Elementos</span>
                </h1>

                {{-- Barra de búsqueda --}}
                <form action="{{ route('user.catalogo') }}" method="GET" id="search-form">
                    <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                    <div class="relative max-w-xl mx-auto">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Buscar por nombre o código SENA…"
                               class="w-full pl-12 pr-32 py-3.5 rounded-2xl text-sm font-medium text-slate-700 bg-white shadow-xl border-0 focus:ring-2 focus:ring-[#39A900] outline-none transition">
                        <button type="submit"
                                class="absolute right-2 top-1/2 -translate-y-1/2 px-5 py-2 bg-[#39A900] hover:bg-green-700 text-white text-xs font-black uppercase tracking-wider rounded-xl transition active:scale-95 shadow-md shadow-green-900/30">
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Flash mensaje --}}
            @if(session('success'))
                <div class="mb-6 bg-white border-l-4 border-[#39A900] text-[#00324D] px-5 py-3.5 rounded-xl shadow-sm flex items-center gap-3 text-sm font-bold" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <svg class="w-5 h-5 text-[#39A900] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ─── Filtros por categoría (chips) ─── --}}
            <div class="flex items-center gap-2 flex-wrap mb-6">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-1">Categoría:</span>

                <a href="{{ route('user.catalogo', array_merge(request()->only('search'), ['categoria' => ''])) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wide transition-all border
                          {{ !request('categoria') ? 'bg-[#39A900] text-white border-[#39A900] shadow-md' : 'bg-white text-slate-500 border-slate-200 hover:border-[#39A900] hover:text-[#39A900]' }}">
                    Todos
                </a>

                @foreach($categorias as $cat)
                    <a href="{{ route('user.catalogo', array_merge(request()->only('search'), ['categoria' => $cat->id])) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wide transition-all border
                              {{ request('categoria') == $cat->id ? 'bg-[#39A900] text-white border-[#39A900] shadow-md shadow-green-100' : 'bg-white text-slate-500 border-slate-200 hover:border-[#39A900] hover:text-[#39A900]' }}">
                        {{ $cat->nombre }}
                    </a>
                @endforeach
            </div>

            {{-- Contador de resultados --}}
            <div class="flex items-center justify-between mb-5">
                <p class="text-xs text-slate-400 font-bold">
                    <span class="text-[#00324D] font-black text-sm">{{ $elementos->total() }}</span>
                    elemento{{ $elementos->total() !== 1 ? 's' : '' }} disponible{{ $elementos->total() !== 1 ? 's' : '' }}
                    @if(request('search'))
                        para <span class="text-[#39A900]">"{{ request('search') }}"</span>
                    @endif
                </p>
                @if(request('search') || request('categoria'))
                    <a href="{{ route('user.catalogo') }}" 
                       class="px-4 py-2 bg-rose-50 border border-rose-100 text-rose-600 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 hover:bg-rose-100 hover:shadow-lg hover:shadow-rose-900/5 transition-all active:scale-95 group/clear">
                        <svg class="w-3.5 h-3.5 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        Restablecer Búsqueda
                    </a>
                @endif
            </div>

            {{-- ─── Grid de cards ─── --}}
            @if($elementos->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach ($elementos as $elemento)
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group">

                            {{-- Imagen o placeholder --}}
                            <div class="h-32 bg-slate-50 flex items-center justify-center border-b border-slate-100 relative overflow-hidden">
                                @if($elemento->imagen)
                                    <img src="{{ asset('storage/' . $elemento->imagen) }}"
                                         alt="{{ $elemento->nombre }}"
                                         class="h-full w-full object-contain p-3 group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="flex flex-col items-center gap-1.5 text-slate-200">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <span class="text-[8px] font-black uppercase tracking-widest">Sin imagen</span>
                                    </div>
                                @endif
                                {{-- Badge categoría --}}
                                <span class="absolute top-2 left-2 px-2 py-0.5 bg-[#00324D]/80 backdrop-blur-sm text-white text-[8px] font-black uppercase tracking-wider rounded-md">
                                    {{ $elemento->categoria->nombre }}
                                </span>
                            </div>

                            {{-- Contenido --}}
                            <div class="p-3 flex flex-col flex-grow gap-2">
                                <div>
                                    <h3 class="font-black text-[#00324D] text-[13px] leading-tight line-clamp-1 group-hover:text-[#39A900] transition-colors">
                                        {{ $elemento->nombre }}
                                    </h3>
                                    <p class="text-[9px] font-mono font-bold text-slate-400 mt-0.5">{{ $elemento->codigo_sena }}</p>
                                </div>

                                <div class="mt-auto">
                                    @php $sancionActual = Auth::user()->obtenerSancionActiva(); @endphp
                                    @if($sancionActual)
                                        <div class="w-full p-2 bg-rose-50 border border-rose-100 rounded-xl text-center">
                                            <p class="text-[9px] font-black text-rose-600 uppercase tracking-widest flex items-center justify-center gap-1 mb-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                                Cuenta Sancionada
                                            </p>
                                            <p class="text-[10px] font-bold text-slate-700 leading-tight mb-1">
                                                Motivo: <span class="text-slate-500 font-medium italic">"{{ $sancionActual->motivo }}"</span>
                                            </p>
                                            <p class="text-[8px] font-black text-slate-400">Hasta: {{ $sancionActual->fecha_fin->format('d/m/Y') }}</p>
                                        </div>
                                    @elseif(Auth::user()->estaSancionado())
                                        <div class="w-full py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-center">
                                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-wider">🔒 Bloqueado administrativamente</p>
                                        </div>
                                    @else
                                        <button @click="openModal = true; elementoId = {{ $elemento->id }}; elementoNombre = '{{ $elemento->nombre }}'"
                                                class="w-full py-2 bg-[#39A900] hover:bg-green-700 text-white text-[10px] font-black uppercase tracking-widest rounded-lg transition-all active:scale-95 shadow-sm shadow-green-100 flex items-center justify-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Solicitar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                {{-- Estado vacío --}}
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mb-5 border border-slate-100">
                        <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <p class="font-black text-[#00324D] text-lg mb-1">Sin resultados</p>
                    <p class="text-sm text-slate-400 mb-5">No hay elementos disponibles con ese criterio de búsqueda.</p>
                    <a href="{{ route('user.catalogo') }}"
                       class="px-6 py-2.5 bg-[#39A900] text-white text-xs font-black uppercase tracking-widest rounded-xl transition hover:bg-green-700 active:scale-95">
                        Ver todos
                    </a>
                </div>
            @endif

            {{-- Paginación --}}
            @if($elementos->hasPages())
                <div class="mt-10">
                    {{ $elementos->withQueryString()->links() }}
                </div>
            @endif

        </div>

        {{-- ─── Modal de Solicitud ─── --}}
        <div x-show="openModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Overlay --}}
                <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" @click="openModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-[#00324D] tracking-tight">Solicitud de Préstamo</h3>
                            <button @click="openModal = false" class="text-slate-400 hover:text-rose-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 mb-6 border border-slate-100">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Elemento seleccionado</p>
                            <p class="text-sm font-black text-[#00324D]" x-text="elementoNombre"></p>
                        </div>

                        <form :action="'{{ route('user.solicitar') }}'" method="POST" @submit="submitting = true">
                            @csrf
                            <input type="hidden" name="elemento_id" :value="elementoId">

                            <div class="space-y-4">
                                {{-- Fecha Inicio --}}
                                <div>
                                    <label for="fecha_inicio" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">¿Cuándo lo necesitas? (Inicio)</label>
                                    <input type="datetime-local" 
                                           id="fecha_inicio" 
                                           name="fecha_inicio" 
                                           required
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-[#00324D] focus:ring-4 focus:ring-[#39A900]/10 focus:border-[#39A900] transition-all outline-none">
                                </div>

                                {{-- Fecha Fin --}}
                                <div>
                                    <label for="fecha_devolucion_esperada" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">¿Cuándo lo devuelves? (Fin)</label>
                                    <input type="datetime-local" 
                                           id="fecha_devolucion_esperada" 
                                           name="fecha_devolucion_esperada" 
                                           required
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-[#00324D] focus:ring-4 focus:ring-[#39A900]/10 focus:border-[#39A900] transition-all outline-none">
                                    <p class="text-[9px] text-slate-400 mt-2 ml-1 italic font-medium">Define el rango exacto de tiempo para el préstamo.</p>
                                </div>

                                <div>
                                    <label for="observaciones" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Propósito / Observaciones</label>
                                    <textarea id="observaciones" 
                                              name="observaciones" 
                                              rows="2" 
                                              placeholder="¿Para qué necesitas el equipo?"
                                              class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-medium text-[#00324D] focus:ring-4 focus:ring-[#39A900]/10 focus:border-[#39A900] transition-all outline-none resize-none placeholder:text-slate-300"></textarea>
                                </div>
                            </div>

                            <div class="mt-8 flex gap-3">
                                <button type="button" 
                                        @click="openModal = false"
                                        class="flex-1 px-6 py-3 border border-slate-200 rounded-xl text-xs font-black text-slate-500 uppercase tracking-widest hover:bg-slate-50 transition-all active:scale-95">
                                    Cancelar
                                </button>
                                <button type="submit"
                                        :disabled="submitting"
                                        class="flex-1 px-6 py-3 bg-[#39A900] text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-green-700 transition-all active:scale-95 shadow-lg shadow-green-100 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                    <template x-if="!submitting">
                                        <span>Confirmar</span>
                                    </template>
                                    <template x-if="submitting">
                                        <div class="flex items-center gap-2">
                                            <svg class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>Procesando...</span>
                                        </div>
                                    </template>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-user-layout>