<x-admin-layout>

    {{-- ───────────── Header ───────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] text-slate-400 dark:text-slate-500 mb-1 font-bold uppercase tracking-widest">
                <a href="{{ route('admin.elementos.index') }}" class="hover:text-[#39A900] transition-colors">Elementos</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-[#00324D] dark:text-white">{{ $elemento->nombre }}</span>
            </div>
            <h2 class="font-black text-xl text-[#00324D] dark:text-white tracking-tight">Detalle del Equipo</h2>
        </div>

        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ route('admin.elementos.index') }}"
               class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black text-slate-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all active:scale-95 uppercase tracking-wide shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver
            </a>
            <a href="{{ route('admin.elementos.edit', $elemento) }}"
               class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-black text-white bg-[#39A900] hover:bg-green-700 shadow-lg shadow-green-100 transition-all active:scale-95 uppercase tracking-wide">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar
            </a>
        </div>
    </div>

    @php
        $statusConfig = match($elemento->estado) {
            'Disponible' => ['bg' => 'from-green-500 to-green-600', 'light' => 'bg-green-50 dark:bg-green-900/20', 'text' => 'text-green-700 dark:text-green-400', 'dot' => 'bg-green-500'],
            'Prestado' => ['bg' => 'from-blue-500 to-blue-600', 'light' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-700 dark:text-blue-400', 'dot' => 'bg-blue-500'],
            'En Mantenimiento' => ['bg' => 'from-amber-400 to-amber-500', 'light' => 'bg-amber-50 dark:bg-amber-900/20', 'text' => 'text-amber-700 dark:text-amber-400', 'dot' => 'bg-amber-400'],
            'Dado de Baja' => ['bg' => 'from-rose-500 to-rose-600', 'light' => 'bg-rose-50 dark:bg-rose-900/20', 'text' => 'text-rose-700 dark:text-rose-400', 'dot' => 'bg-rose-500'],
            default => ['bg' => 'from-slate-400 to-slate-500', 'light' => 'bg-slate-50 dark:bg-slate-900/20', 'text' => 'text-slate-700 dark:text-slate-400', 'dot' => 'bg-slate-500']
        };
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Izquierda: Imagen --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden p-6 flex items-center justify-center min-h-[300px]">
                @if($elemento->imagen)
                    <img src="{{ asset('storage/' . $elemento->imagen) }}"
                         alt="{{ $elemento->nombre }}"
                         class="w-full h-auto max-h-[400px] object-contain rounded-2xl">
                @else
                    <div class="flex flex-col items-center gap-4 text-slate-200 dark:text-slate-700">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <p class="text-xs font-black uppercase tracking-widest text-slate-300 dark:text-slate-600">Sin imagen disponible</p>
                    </div>
                @endif
            </div>

            <div class="bg-gradient-to-br {{ $statusConfig['bg'] }} rounded-3xl p-6 shadow-lg text-white">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-1">Estado de Inventario</p>
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full bg-white animate-pulse"></div>
                    <span class="text-xl font-black uppercase tracking-tight">{{ $elemento->estado }}</span>
                </div>
            </div>
        </div>

        {{-- Derecha: Información --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Card: Datos Generales --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex justify-between items-center">
                    <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Información General</p>
                    <span class="px-3 py-1 bg-[#00324D] dark:bg-slate-800 text-white text-[10px] font-bold rounded-full uppercase tracking-widest border border-slate-700 dark:border-slate-600">
                        {{ $elemento->categoria->nombre }}
                    </span>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Nombre del Elemento</p>
                        <p class="text-lg font-black text-[#00324D] dark:text-white leading-tight">{{ $elemento->nombre }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Código SENA / Placa</p>
                        <p class="text-lg font-mono font-black text-[#39A900]">{{ $elemento->codigo_sena }}</p>
                    </div>
                    <div class="sm:col-span-2 space-y-1 pt-4 border-t border-slate-50 dark:border-slate-800">
                        <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Descripción</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 font-medium leading-relaxed">
                            {{ $elemento->descripcion ?? 'Sin descripción adicional.' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Card: Auditoría Temporal --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                    <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Trazabilidad de Registro</p>
                </div>
                <div class="p-6 flex flex-wrap gap-8">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-slate-50 dark:bg-slate-800 rounded-xl">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest leading-none mb-1">Fecha Registro</p>
                            <p class="text-xs font-black text-[#00324D] dark:text-white">{{ $elemento->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-slate-50 dark:bg-slate-800 rounded-xl">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">Último Cambio</p>

        </div>

    </div>

</x-admin-layout>
