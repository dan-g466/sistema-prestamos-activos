<x-admin-layout>
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-red-50 rounded-2xl shadow-sm border border-red-100 hidden sm:block">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-[#00324D] leading-tight tracking-tight">
                    {{ __('Préstamos') }} <span class="text-red-600">Vencidos</span>
                </h2>
                <p class="text-slate-600 text-[10px] uppercase font-black tracking-widest mt-1">
                    Control de Mora y Retrasos <span class="mx-2 text-slate-300">|</span> <span class="text-red-600 font-bold uppercase animate-pulse">Atención Requerida</span>
                </p>
            </div>
        </div>
        <a href="{{ route('admin.prestamos.index') }}" 
           class="flex items-center gap-2 text-slate-400 hover:text-[#00324D] transition-all group px-4 py-2 bg-white rounded-xl border border-slate-50 shadow-sm active:scale-95">
            <div class="p-1.5 rounded-lg bg-slate-50 group-hover:bg-slate-100 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest">Volver al Control</span>
        </a>
    </div>

    <div class="max-w-7xl mx-auto pb-8">
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mx-4 sm:mx-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-red-50/30 uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-red-700">Aprendiz en Mora</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-red-700">Equipo Retrasado</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-red-700">Gravedad / Mora</th>
                            <th class="px-8 py-2 text-right text-[8px] font-black text-red-700">Acción Requerida</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse ($prestamos as $prestamo)
                            @php
                                $tiempoAtrasado = $prestamo->fecha_devolucion_esperada->diffForHumans(now(), [
                                    'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                                    'parts' => 2,
                                    'skip' => ['week'],
                                ]);
                            @endphp
                            <tr class="hover:bg-red-50/30 transition-colors group/row text-[11px] bg-rose-50/10">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 font-black text-[10px] uppercase border border-rose-200">
                                            {{ substr($prestamo->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-[#00324D] uppercase leading-tight">
                                                {{ $prestamo->user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-2">
                                    <div class="font-bold text-[#00324D]">{{ $prestamo->elemento->nombre }}</div>
                                    <div class="text-[9px] font-mono font-bold text-slate-400 mt-0.5">ID: {{ $prestamo->elemento->codigo_sena }}</div>
                                </td>

                                <td class="px-6 py-2">
                                    <div class="flex flex-col gap-1">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-rose-600 text-white rounded-full text-[8px] font-black uppercase tracking-widest w-fit shadow-lg shadow-rose-600/20 animate-pulse">
                                            {{ $tiempoAtrasado }} de Retraso
                                        </span>
                                        <span class="text-[8px] text-slate-400 font-bold ml-1 uppercase">Debía Entregar: {{ $prestamo->fecha_devolucion_esperada->format('d/m/Y - h:i A') }}</span>
                                    </div>
                                </td>

                                <td class="px-8 py-2 text-right">
                                    <div class="flex justify-end items-center gap-1.5">
                                        <a href="{{ route('admin.prestamos.show', $prestamo) }}"
                                           class="p-1 px-3 bg-slate-100 text-[#00324D] hover:bg-slate-200 rounded-lg transition-all border border-slate-200 shadow-sm active:scale-95 flex items-center gap-1.5"
                                           title="Ver detalle">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Ver
                                        </a>

                                        <button onclick="abrirModalDevolucion('{{ $prestamo->id }}', '{{ $prestamo->elemento->nombre }}')" 
                                                class="p-1 px-3 bg-rose-600 text-white rounded-lg hover:bg-rose-700 font-black text-[9px] uppercase tracking-widest transition-all shadow-sm active:scale-95 flex items-center gap-1.5"
                                                title="Recibir y Sancionar">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 15L12 19M12 19L8 15M12 19V9M5 20H19"/></svg>
                                            Recibir
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest leading-loose">No hay préstamos vencidos. ¡Excelente control!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($prestamos->hasPages())
                <div class="px-6 py-2 border-t border-slate-100 bg-slate-50/30">
                    {{ $prestamos->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Devolución Premium (Copiado de Index para consistencia) -->
    <div id="modalDevolucion" class="fixed inset-0 z-[110] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all border border-slate-100">
            <div class="h-2 bg-gradient-to-r from-rose-600 to-[#00324D]"></div>
            <div class="p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-rose-50 rounded-2xl">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-[#00324D] leading-tight">Reingreso en Mora</h3>
                        <p id="txtElemento" class="text-[10px] font-black text-rose-600 uppercase tracking-widest mt-0.5"></p>
                    </div>
                </div>
                
                <form id="formFinalizar" method="POST">
                    @csrf
                    <div class="mb-6 space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Observaciones de Entrega</label>
                        <textarea name="observaciones" rows="4" 
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-[13px] font-medium text-[#00324D] focus:ring-4 focus:ring-rose-500/5 focus:border-rose-500 transition-all outline-none placeholder:text-slate-300 resize-none leading-relaxed" 
                                placeholder="Describe el estado en el que se recibe el equipo y detalles del retraso..."></textarea>
                    </div>
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="w-full py-4 bg-[#00324D] text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-[#002538] shadow-lg shadow-[#00324D]/20 transition-all hover:scale-[1.02] active:scale-95">
                            Confirmar y Sancionar
                        </button>
                        <button type="button" onclick="cerrarModal()" class="w-full py-3 text-slate-400 font-black text-[10px] uppercase tracking-widest hover:text-slate-600 transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function abrirModalDevolucion(id, nombre) {
            document.getElementById('formFinalizar').action = `/admin/prestamos/${id}/finalizar`;
            document.getElementById('txtElemento').innerText = nombre;
            document.getElementById('modalDevolucion').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function cerrarModal() {
            document.getElementById('modalDevolucion').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</x-admin-layout>
