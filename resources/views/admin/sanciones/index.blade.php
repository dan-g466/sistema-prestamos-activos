<x-admin-layout>
    {{-- Header --}}
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 hidden sm:block">
                <svg class="w-6 h-6 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-[#00324D] dark:text-white leading-tight tracking-tight">
                    {{ __('Sanciones') }} <span class="text-[#39A900]">SENA</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-[10px] uppercase font-black tracking-widest mt-1">
                    Gestión de Bloqueos <span class="mx-2 text-slate-300 dark:text-slate-700">|</span> <span class="text-[#39A900]">Admin</span>
                </p>
            </div>
        </div>
        <a href="{{ route('admin.sanciones.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-[#39A900] text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#2d8500] transition-all shadow-lg shadow-[#39A900]/30 active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Aplicar Sanción
        </a>
    </div>

    <div class="max-w-7xl mx-auto pb-8">

        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                    <thead class="bg-slate-50/50 dark:bg-slate-800/10">
                        <tr>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">Usuario Sena</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">Motivo</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">Vigencia</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">Estado</th>
                            <th class="px-8 py-4 text-right text-[9px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($sanciones as $sancion)
                            @php $esActiva = $sancion->fecha_fin >= now(); @endphp
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group/row text-[11px]">
                                {{-- Aprendiz --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#39A900] to-green-600 flex items-center justify-center text-white font-black text-[10px] uppercase shadow-lg shadow-green-900/10">
                                            {{ strtoupper(substr($sancion->user->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-[#00324D] dark:text-white leading-tight uppercase">{{ $sancion->user->name ?? 'Usuario eliminado' }}</div>
                                            <div class="text-[9px] font-black text-[#39A900] uppercase tracking-tighter">{{ $sancion->user->documento ?? '—' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Motivo --}}
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400 max-w-xs">
                                    <span class="line-clamp-2 leading-relaxed font-medium">{{ $sancion->motivo }}</span>
                                </td>

                                {{-- Vigencia --}}
                                <td class="px-6 py-4">
                                    <span class="block text-slate-400 dark:text-slate-600 font-black text-[8px] uppercase tracking-widest">Inicio: {{ optional($sancion->fecha_inicio)->format('d/m/Y') ?? '—' }}</span>
                                    <span class="block font-black text-[#00324D] dark:text-slate-200 text-[9px] mt-1 uppercase">Fin: {{ optional($sancion->fecha_fin)->format('d/m/Y') ?? '—' }}</span>
                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-4">
                                    @if($esActiva)
                                        <span class="px-2.5 py-1 bg-[#39A900] text-white rounded-full text-[8px] font-black uppercase tracking-widest shadow-lg shadow-green-900/10">ACTIVA</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-600 rounded-full text-[8px] font-black uppercase tracking-widest border border-slate-200 dark:border-slate-700">EXPIRADA</span>
                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td class="px-8 py-4 text-right">
                                    <div class="flex justify-end items-center gap-1.5">
                                        {{-- Editar --}}
                                        <a href="{{ route('admin.sanciones.edit', ['sancion' => $sancion]) }}"
                                           class="p-1.5 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-[#39A900] hover:text-white rounded-lg transition-all border border-slate-200 dark:border-slate-700 hover:border-[#39A900] shadow-sm active:scale-90"
                                           title="Editar">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>

                                        {{-- Eliminar con SweetAlert2 --}}
                                        <form id="sancion-delete-{{ $sancion->id }}"
                                              action="{{ route('admin.sanciones.destroy', ['sancion' => $sancion]) }}"
                                              method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button"
                                                    onclick="confirmDelete('sancion-delete-{{ $sancion->id }}', 'Se levantará la sanción de {{ addslashes($sancion->user->name ?? "este usuario") }} del sistema.')"
                                                    class="p-1.5 bg-rose-50 dark:bg-rose-900/20 text-rose-500 dark:text-rose-400 hover:bg-rose-500 hover:text-white rounded-lg transition-all border border-rose-100 dark:border-rose-900 hover:border-rose-500 shadow-sm active:scale-90"
                                                    title="Levantar Sanción">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-slate-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-widest">No hay sanciones registradas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($sanciones->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20">
                    {{ $sanciones->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
