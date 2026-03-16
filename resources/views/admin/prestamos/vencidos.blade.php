<x-admin-layout>
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-red-50 dark:bg-red-900/40 rounded-2xl shadow-sm border border-red-100 dark:border-red-800/50 hidden sm:block">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-[#00324D] dark:text-white leading-tight tracking-tight">
                    {{ __('Préstamos') }} <span class="text-red-600 dark:text-red-500">Vencidos</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-[10px] uppercase font-black tracking-widest mt-1">
                    Control de Mora y Retrasos <span class="mx-2 text-slate-300 dark:text-slate-600">|</span> <span class="text-red-600 dark:text-red-400 font-bold uppercase animate-pulse">Atención Requerida</span>
                </p>
            </div>
        </div>
        <a href="{{ route('admin.prestamos.index') }}" 
           class="flex items-center gap-2 text-slate-400 dark:text-slate-500 hover:text-[#00324D] dark:hover:text-white transition-all group px-4 py-2 bg-white dark:bg-slate-800 rounded-xl border border-slate-50 dark:border-slate-700/50 shadow-sm active:scale-95">
            <div class="p-1.5 rounded-lg bg-slate-50 dark:bg-slate-700/50 group-hover:bg-slate-100 dark:group-hover:bg-slate-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest">Volver al Control</span>
        </a>
    </div>

    <div class="max-w-7xl mx-auto pb-8">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden mx-4 sm:mx-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800/60">
                    <thead class="bg-red-50/30 dark:bg-red-900/20 uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-red-700 dark:text-red-400">Aprendiz en Mora</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-red-700 dark:text-red-400">Equipo Retrasado</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-red-700 dark:text-red-400">Gravedad / Mora</th>
                            <th class="px-8 py-2 text-right text-[8px] font-black text-red-700 dark:text-red-400">Acción Requerida</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-800/60">
                        @forelse ($prestamos as $prestamo)
                            @php
                                $tiempoAtrasado = $prestamo->fecha_devolucion_esperada->diffForHumans(now(), [
                                    'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                                    'parts' => 2,
                                    'skip' => ['week'],
                                ]);
                            @endphp
                            <tr class="hover:bg-red-50/30 dark:hover:bg-red-900/10 transition-colors group/row text-[11px] bg-rose-50/10 dark:bg-slate-900">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center text-rose-600 dark:text-rose-400 font-black text-[10px] uppercase border border-rose-200 dark:border-rose-800/30">
                                            {{ substr($prestamo->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-[#00324D] dark:text-white uppercase leading-tight">
                                                {{ $prestamo->user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-2">
                                    <div class="font-bold text-[#00324D] dark:text-white">{{ $prestamo->elemento->nombre }}</div>
                                    <div class="text-[9px] font-mono font-bold text-slate-400 dark:text-slate-500 mt-0.5">ID: {{ $prestamo->elemento->codigo_sena }}</div>
                                </td>

                                <td class="px-6 py-2">
                                    <div class="flex flex-col gap-1">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-rose-600 dark:bg-rose-500 text-white rounded-full text-[8px] font-black uppercase tracking-widest w-fit shadow-lg shadow-rose-600/20 dark:shadow-rose-900/20 animate-pulse">
                                            {{ $tiempoAtrasado }} de Retraso
                                        </span>
                                        <span class="text-[8px] text-slate-400 dark:text-slate-500 font-bold ml-1 uppercase">Debía Entregar: {{ $prestamo->fecha_devolucion_esperada->format('d/m/Y - h:i A') }}</span>
                                    </div>
                                </td>

                                <td class="px-8 py-2 text-right">
                                    <div class="flex justify-end items-center gap-1.5">
                                        <a href="{{ route('admin.prestamos.show', $prestamo) }}"
                                           class="p-1 px-3 bg-slate-100 dark:bg-slate-800 text-[#00324D] dark:text-white hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-all border border-slate-200 dark:border-slate-700 shadow-sm active:scale-95 flex items-center gap-1.5"
                                           title="Ver detalle">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Ver
                                        </a>

                                        <button onclick="abrirModalDevolucion('{{ $prestamo->id }}', '{{ $prestamo->elemento->nombre }}')" 
                                                class="p-1 px-3 bg-rose-600 dark:bg-rose-500 text-white rounded-lg hover:bg-rose-700 dark:hover:bg-rose-600 font-black text-[9px] uppercase tracking-widest transition-all shadow-sm active:scale-95 flex items-center gap-1.5"
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
                                        <svg class="w-10 h-10 text-emerald-100 dark:text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-widest leading-loose">No hay préstamos vencidos. ¡Excelente control!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($prestamos->hasPages())
                <div class="px-6 py-2 border-t border-slate-100 dark:border-slate-800/60 bg-slate-50/30 dark:bg-slate-800/20">
                    {{ $prestamos->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Devolución Premium (Copiado de Index para consistencia) -->
    <div id="modalDevolucion" class="fixed inset-0 z-[110] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all border border-slate-100 dark:border-slate-800">
            <div class="h-2 bg-gradient-to-r from-rose-600 to-[#00324D] dark:to-slate-800"></div>
            <div class="p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-rose-50 dark:bg-rose-900/20 rounded-2xl border border-rose-100 dark:border-rose-900/30">
                        <svg class="w-6 h-6 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-[#00324D] dark:text-white leading-tight">Reingreso en Mora</h3>
                        <p id="txtElemento" class="text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest mt-0.5"></p>
                    </div>
                </div>
                
                <form id="formFinalizar" method="POST">
                    @csrf
                    <div class="mb-6 space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">Observaciones de Entrega</label>
                        <textarea name="observaciones" rows="4" 
                                class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-[13px] font-medium text-[#00324D] dark:text-white focus:ring-4 focus:ring-rose-500/5 dark:focus:ring-rose-500/10 focus:border-rose-500 dark:focus:border-rose-500 transition-all outline-none placeholder:text-slate-300 dark:placeholder:text-slate-600 resize-none leading-relaxed" 
                                placeholder="Describe el estado en el que se recibe el equipo y detalles del retraso..."></textarea>
                    </div>
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="w-full py-4 bg-[#00324D] dark:bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-[#002538] dark:hover:bg-emerald-500 shadow-lg shadow-[#00324D]/20 dark:shadow-emerald-900/20 transition-all hover:scale-[1.02] active:scale-95">
                            Confirmar y Sancionar
                        </button>
                        <button type="button" onclick="cerrarModal()" class="w-full py-3 text-slate-400 dark:text-slate-500 font-black text-[10px] uppercase tracking-widest hover:text-slate-600 dark:hover:text-slate-400 transition-colors">
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
