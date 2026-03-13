<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-2">
        <div>
            <h2 class="font-black text-xl text-[#00324D] dark:text-white leading-tight tracking-tight">
                {{ __('Categorías') }} <span class="text-[#39A900]">SENA</span>
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-[9px] uppercase font-black tracking-[0.2em]">Gestión de tipos de activos</p>
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <a href="{{ route('admin.categorias.create') }}" class="bg-[#39A900] hover:bg-[#2d8500] text-white font-black py-1.5 px-5 rounded-xl shadow-lg shadow-[#39A900]/20 transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95 flex items-center gap-2 group text-[10px] uppercase tracking-widest">
                <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Nueva Categoría</span>
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <!-- Barra de Filtros Compacta -->
        <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl border border-white/40 dark:border-slate-800 p-2 rounded-2xl shadow-sm mb-4 mx-4 sm:mx-0">
            <form action="{{ route('admin.categorias.index') }}" method="GET" class="flex flex-col lg:flex-row items-center gap-4">
                <!-- Búsqueda -->
                <div class="w-full lg:flex-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-slate-600 group-focus-within:text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Buscar por nombre o descripción..." 
                               class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-[#00324D] dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all placeholder:font-medium">
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full lg:w-auto">
                    <button type="submit" class="p-2 bg-[#39A900] text-white rounded-xl hover:bg-[#2d8500] transition-all active:scale-95 shadow-lg shadow-[#39A900]/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    </button>
                    <a href="{{ route('admin.categorias.index') }}" class="p-2 bg-white dark:bg-slate-800 border border-blue-200 dark:border-blue-900/30 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all" title="Limpiar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden mx-4 sm:mx-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                    <thead class="bg-slate-50/50 dark:bg-slate-800/50 uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-600 dark:text-slate-400">Nombre de Categoría</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-600 dark:text-slate-400">Descripción / Detalles</th>
                            <th class="px-8 py-2 text-left text-[8px] font-black text-slate-600 dark:text-slate-400">Volumen</th>
                            <th class="px-8 py-2 text-right text-[8px] font-black text-slate-600 dark:text-slate-400">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($categorias as $categoria)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group/row text-[11px]">
                                <td class="px-6 py-2 font-black text-[#00324D] dark:text-white uppercase group-hover:text-[#39A900] tracking-tight whitespace-nowrap">
                                    {{ $categoria->nombre }}
                                </td>
                                <td class="px-6 py-2 text-slate-600 dark:text-slate-400 font-medium truncate max-w-[300px]" title="{{ $categoria->descripcion }}">
                                    {{ $categoria->descripcion ?? 'Sin descripción detallada' }}
                                </td>
                                <td class="px-8 py-2">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-[#39A900]/10 dark:bg-[#39A900]/20 text-[#39A900] dark:text-[#39A900] rounded-full text-[8px] font-black uppercase tracking-widest border border-[#39A900]/10">
                                        <span class="w-1 h-1 rounded-full bg-[#39A900]"></span>
                                        {{ $categoria->elementos()->count() }} elementos
                                    </span>
                                </td>
                                <td class="px-8 py-2 text-right">
                                    <div class="flex justify-end items-center gap-1.5 transition-all">
                                        <a href="{{ route('admin.categorias.edit', $categoria) }}"
                                           class="p-1.5 bg-green-50 dark:bg-green-900/20 text-[#39A900] hover:bg-[#39A900] hover:text-white rounded-lg transition-all border border-green-200 dark:border-green-800 shadow-sm active:scale-90"
                                           title="Editar">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form id="cat-delete-{{ $categoria->id }}" action="{{ route('admin.categorias.destroy', $categoria) }}"
                                              method="POST"
                                              class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button"
                                                    class="p-1.5 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white rounded-lg transition-all border border-rose-200 dark:border-rose-800 shadow-sm active:scale-90"
                                                    onclick="confirmDelete('cat-delete-{{ $categoria->id }}', '¿Eliminar Categoría?', '¿Deseas eliminar esta categoría?', true, {{ $categoria->elementos()->count() }})"
                                                    title="Eliminar">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-slate-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-widest leading-loose">No hay categorías registradas.</p>
                                        <a href="{{ route('admin.categorias.create') }}" class="text-[#39A900] font-black hover:bg-[#39A900]/5 px-4 py-1.5 rounded-xl border border-dashed border-[#39A900] uppercase tracking-widest text-[9px] mt-2 transition-all">Crear la primera</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($categorias->hasPages())
                <div class="px-6 py-2 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20">
                    {{ $categorias->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
