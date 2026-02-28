<x-user-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Cabecera de Sección --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-in fade-in slide-in-from-top-4 duration-700">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-100 rounded-full mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="text-[9px] font-black text-amber-600 uppercase tracking-widest">En Trámite</span>
                </div>
                <h2 class="text-3xl font-black text-[#00324D] tracking-tighter uppercase">Mis Solicitudes</h2>
                <p class="text-slate-400 text-xs font-medium mt-1">Sigue el estado de tus peticiones en revisión o aprobadas.</p>
            </div>
            <a href="{{ route('user.catalogo') }}" class="px-6 py-3 bg-[#39A900] text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-[#39A900]/20 hover:shadow-[#39A900]/40 transition-all active:scale-95 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                Nueva Solicitud
            </a>
        </div>

        @if($prestamos->count() > 0)
            {{-- Listado Horizontal Premium --}}
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/40 border border-slate-100 overflow-hidden animate-in fade-in slide-in-from-bottom-6 duration-1000 delay-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-50 bg-slate-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Equipo</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hidden md:table-cell">Código</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Rango de Fecha</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Estado</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Seguimiento</th>
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
                                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">
                                                    {{ optional($p->elemento->categoria)->nombre ?? 'Sin categoría' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <span class="text-[11px] font-mono font-bold text-slate-400 bg-slate-50 px-2 py-0.5 rounded border border-slate-100">{{ optional($p->elemento)->codigo_sena ?? '—' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[8px] font-black text-slate-300 uppercase w-8">Inicio:</span>
                                                <span class="text-[10px] font-bold text-[#00324D]">{{ $p->fecha_inicio ? $p->fecha_inicio->format('d/m/Y h:i A') : 'Por definir' }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-[8px] font-black text-slate-300 uppercase w-8">Final:</span>
                                                <span class="text-[10px] font-bold {{ $p->estado === 'Vencido' ? 'text-rose-500 animate-pulse' : 'text-[#00324D]' }}">
                                                    {{ $p->fecha_devolucion_esperada ? $p->fecha_devolucion_esperada->format('d/m/Y h:i A') : 'Por definir' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusStyles = [
                                                'Pendiente' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                'Aceptado'  => 'bg-blue-50 text-blue-600 border-blue-100',
                                                'Activo'    => 'bg-green-50 text-[#39A900] border-green-100',
                                                'Vencido'   => 'bg-rose-50 text-rose-600 border-rose-100',
                                            ];
                                            $currentStyle = $statusStyles[$p->estado] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                        @endphp
                                        <span class="px-2.5 py-1 {{ $currentStyle }} border rounded-full text-[8px] font-black uppercase tracking-widest inline-flex items-center gap-1.5">
                                            <span class="w-1 h-1 rounded-full bg-current {{ $p->estado === 'Activo' ? 'animate-pulse' : '' }}"></span>
                                            {{ $p->estado }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <a href="{{ route('user.prestamos.show', $p) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-[#00324D] hover:shadow-lg transition-all active:scale-95 group/btn">
                                            Proceso
                                            <svg class="w-3.5 h-3.5 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5-5 5M6 7l5 5-5 5"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Paginación --}}
            <div class="mt-8">
                {{ $prestamos->links() }}
            </div>

        @else
            {{-- Estado Vacío --}}
            <div class="flex flex-col items-center justify-center py-24 text-center animate-in fade-in duration-1000">
                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100 shadow-inner group">
                    <svg class="w-12 h-12 text-slate-200 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                </div>
                <h3 class="text-xl font-black text-[#00324D] tracking-tighter uppercase mb-2">Sin solicitudes</h3>
                <p class="text-slate-400 text-xs max-w-xs mx-auto mb-8">No tienes peticiones pendientes de revisión en este momento.</p>
                <a href="{{ route('user.catalogo') }}" class="px-6 py-3 bg-[#39A900] text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl shadow-xl shadow-[#39A900]/10 transition-all active:scale-95">
                    Ver Catálogo
                </a>
            </div>
        @endif
    </div>
</x-user-layout>
