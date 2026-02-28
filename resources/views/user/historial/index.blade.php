<x-user-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Cabecera de Sección --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-in fade-in slide-in-from-top-4 duration-700">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-100 rounded-full mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Registro de Actividad</span>
                </div>
                <h2 class="text-3xl font-black text-[#00324D] tracking-tighter uppercase">Mi Historial</h2>
                <p class="text-slate-400 text-xs font-medium mt-1">Consulta tus préstamos finalizados y el registro de devoluciones.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="px-5 py-2.5 bg-white rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
                    <span class="text-[10px] font-black text-[#00324D] uppercase tracking-widest">Total: {{ $prestamos->total() }}</span>
                </div>
            </div>
        </div>

        @if($prestamos->count() > 0)
            {{-- Listado Horizontal (Estilo Tabla Moderna) --}}
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/40 border border-slate-100 overflow-hidden animate-in fade-in slide-in-from-bottom-6 duration-1000 delay-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-50 bg-slate-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Equipo</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hidden md:table-cell">Código</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hidden lg:table-cell">Categoría</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Fecha Devolución</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Estado</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($prestamos as $p)
                                <tr class="group hover:bg-slate-50/50 transition-colors duration-300">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                                @if(optional($p->elemento)->imagen)
                                                    <img src="{{ asset('storage/' . $p->elemento->imagen) }}" class="w-7 h-7 object-contain">
                                                @else
                                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-[13px] font-black text-[#00324D] leading-none mb-1 group-hover:text-[#39A900] transition-colors">
                                                    {{ optional($p->elemento)->nombre ?? 'Elemento eliminado' }}
                                                </p>
                                                <p class="text-[10px] font-bold text-slate-400 md:hidden">
                                                    {{ optional($p->elemento)->codigo_sena ?? '—' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <span class="text-[11px] font-mono font-bold text-slate-400">{{ optional($p->elemento)->codigo_sena ?? '—' }}</span>
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[9px] font-black uppercase tracking-widest rounded-lg">
                                            {{ optional($p->elemento->categoria)->nombre ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-[11px] font-black text-[#00324D]">{{ $p->fecha_devolucion_real ? $p->fecha_devolucion_real->format('d/m/Y') : '—' }}</span>
                                            <span class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $p->fecha_devolucion_real ? $p->fecha_devolucion_real->format('h:i A') : 'No registrada' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $color = $p->estado === 'Rechazado' ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-[#39A900]/10 text-[#39A900] border-[#39A900]/20';
                                        @endphp
                                        <span class="px-2.5 py-1 {{ $color }} border rounded-full text-[8px] font-black uppercase tracking-widest inline-flex items-center gap-1.5">
                                            <span class="w-1 h-1 rounded-full bg-current"></span>
                                            {{ $p->estado }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <a href="{{ route('user.prestamos.show', $p) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#00324D] text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-[#39A900] hover:shadow-lg transition-all active:scale-95 group/btn">
                                            Detalles
                                            <svg class="w-3.5 h-3.5 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Paginación Optimizada --}}
            <div class="mt-8">
                {{ $prestamos->links() }}
            </div>

        @else
            {{-- Estado Vacío --}}
            <div class="flex flex-col items-center justify-center py-24 text-center animate-in fade-in duration-1000">
                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100 shadow-inner group">
                    <svg class="w-12 h-12 text-slate-200 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-xl font-black text-[#00324D] tracking-tighter uppercase mb-2">Historial Limpio</h3>
                <p class="text-slate-400 text-xs max-w-xs mx-auto leading-relaxed mb-8">Aún no registras préstamos finalizados en el sistema. ¡Toda tu actividad aparecerá aquí!</p>
                <a href="{{ route('user.catalogo') }}" class="px-6 py-3 bg-[#39A900] text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl shadow-xl shadow-[#39A900]/10 hover:shadow-[#39A900]/20 transition-all active:scale-95">
                    Ir al Catálogo
                </a>
            </div>
        @endif
    </div>
</x-user-layout>