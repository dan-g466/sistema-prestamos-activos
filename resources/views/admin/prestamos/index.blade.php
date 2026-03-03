<x-admin-layout>
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white rounded-2xl shadow-sm border border-slate-100 hidden sm:block">
                <svg class="w-6 h-6 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-[#00324D] leading-tight tracking-tight">
                    {{ __('Control de') }} <span class="text-[#39A900]">Operaciones</span>
                </h2>
                <p class="text-slate-600 text-[10px] uppercase font-black tracking-widest mt-1">
                    Gestión de Préstamos y Devoluciones <span class="mx-2 text-slate-300">|</span> <span class="text-[#39A900]">SENA</span>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.prestamos.vencidos') }}" class="relative inline-flex items-center gap-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white font-black py-2 px-4 rounded-xl transition-all duration-300 group text-[10px] uppercase tracking-widest border border-rose-100 shadow-sm shadow-rose-900/5 active:scale-95">
                <svg class="w-3.5 h-3.5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Ver Vencidos</span>
            </a>
        </div>
    </div>

    <!-- Toast de Notificación Flotante -->
    @if(session('success') || session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-[-20px] scale-95"
             x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 transform translate-y-[-20px] scale-95"
             class="fixed top-20 right-6 z-[100] max-w-sm w-full pointer-events-auto">
            <div class="bg-white border-l-4 {{ session('success') ? 'border-[#39A900]' : 'border-rose-500' }} shadow-[0_10px_30px_-5px_rgba(0,0,0,0.1)] rounded-2xl p-4 flex items-center justify-between group">
                <div class="flex items-center gap-3">
                    <div class="{{ session('success') ? 'bg-green-50' : 'bg-rose-50' }} p-2 rounded-xl">
                        @if(session('success'))
                            <svg class="w-5 h-5 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-[#00324D] leading-none mb-1">{{ session('success') ? '¡Éxito!' : 'Aviso' }}</h4>
                        <p class="text-[11px] font-bold text-slate-600 leading-tight">{{ session('success') ?? session('error') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-slate-300 hover:text-slate-500 transition-colors p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto pb-8">
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mx-4 sm:mx-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50 uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-600">Aprendiz / Solicitante</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-600">Elemento Técnico</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-600">Cronograma / Plazos</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-600">Estado</th>
                            <th class="px-8 py-2 text-right text-[8px] font-black text-slate-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse ($prestamos as $prestamo)
                            @php
                                $esVencido = $prestamo->estado === 'Activo' && $prestamo->fecha_devolucion_esperada->isPast();
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group/row text-[11px] {{ $esVencido ? 'bg-rose-50/30' : '' }}">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[#00324D] font-black text-[10px] uppercase border border-slate-200">
                                            {{ substr($prestamo->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-[#00324D] uppercase group-hover/row:text-[#39A900] transition-colors leading-tight">
                                                {{ $prestamo->user->name }}
                                            </div>
                                            <div class="text-[9px] text-slate-400 font-bold tracking-wider">ID: {{ $prestamo->user->documento }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-2">
                                    <div class="font-bold text-[#00324D]">{{ $prestamo->elemento->nombre }}</div>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="text-[8px] font-black px-1.5 py-0.5 bg-slate-100 text-slate-500 rounded uppercase tracking-tighter border border-slate-200">PLACA</span>
                                        <span class="text-[9px] font-mono font-bold text-[#39A900]">{{ $prestamo->elemento->codigo_sena }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-2 font-medium">
                                    <div class="text-slate-400 text-[9px] uppercase tracking-tighter">Desde: {{ $prestamo->fecha_solicitud->format('d M, Y - H:i') }}</div>
                                    <div class="font-black mt-0.5 flex flex-col gap-1 {{ $esVencido ? 'text-rose-600 animate-pulse' : 'text-slate-600' }}">
                                        <div class="flex items-center gap-1.5">
                                            @if($esVencido)
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            @else
                                                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            @endif
                                            Límite: {{ $prestamo->fecha_devolucion_esperada->format('d M, Y - H:i') }}
                                        </div>
                                        @if($prestamo->observaciones)
                                            <div class="bg-slate-50 border border-slate-100 rounded px-1.5 py-0.5 text-[8px] font-medium text-slate-400 max-w-[180px] truncate" title="{{ $prestamo->observaciones }}">
                                                Obs: {{ $prestamo->observaciones }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-2">
                                    @if($esVencido)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-rose-600 text-white rounded-full text-[8px] font-black uppercase tracking-widest shadow-sm">
                                            <span class="w-1 h-1 rounded-full bg-white animate-ping"></span>
                                            Vencido
                                        </span>
                                    @else
                                        @php
                                            $statusBadge = match($prestamo->estado) {
                                                'Pendiente' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'dot' => 'bg-amber-400'],
                                                'Aceptado'  => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
                                                'Activo'    => ['bg' => 'bg-[#39A900]/10', 'text' => 'text-[#39A900]', 'dot' => 'bg-[#39A900]'],
                                                'Por Confirmar' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'dot' => 'bg-indigo-500'],
                                                'Devuelto'  => ['bg' => 'bg-slate-100', 'text' => 'text-slate-400', 'dot' => 'bg-slate-300'],
                                                'Rechazado' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'dot' => 'bg-rose-400'],
                                                default     => ['bg' => 'bg-slate-50', 'text' => 'text-slate-400', 'dot' => 'bg-slate-200']
                                            };
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 {{ $statusBadge['bg'] }} {{ $statusBadge['text'] }} rounded-full text-[8px] font-black uppercase tracking-widest border {{ str_replace('bg-', 'border-', $statusBadge['bg']) }}">
                                            <span class="w-1 h-1 rounded-full {{ $statusBadge['dot'] }}"></span>
                                            {{ $prestamo->estado }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-8 py-2 text-right">
                                    <div class="flex justify-end items-center gap-1.5 transition-all">
                                        <a href="{{ route('admin.prestamos.show', $prestamo) }}"
                                           class="p-1 px-3 bg-slate-100 text-[#39A900] hover:bg-green-50 rounded-lg transition-all border border-slate-200 shadow-sm active:scale-95 flex items-center gap-1.5"
                                           title="Ver detalle">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Ver
                                        </a>

                                        @if($prestamo->estado == 'Pendiente')
                                            <form action="{{ route('admin.prestamos.aceptar', $prestamo) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1 px-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-black text-[9px] uppercase tracking-widest transition-all shadow-sm active:scale-95 flex items-center gap-1.5" title="Aceptar Solicitud">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    Aceptar
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.prestamos.rechazar', $prestamo) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1 px-3 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 font-black text-[9px] uppercase tracking-widest transition-all active:scale-95 flex items-center gap-1.5" title="Rechazar">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    Rechazar
                                                </button>
                                            </form>
                                        @endif

                                        @if($prestamo->estado == 'Aceptado')
                                            <form action="{{ route('admin.prestamos.entregar', $prestamo) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1 px-3 bg-[#39A900] text-white rounded-lg hover:bg-[#2d8500] font-black text-[9px] uppercase tracking-widest transition-all shadow-sm active:scale-95 flex items-center gap-1.5" title="Entregar Equipo">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                                    Entregar
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.prestamos.rechazar', $prestamo) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1 px-3 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 font-black text-[9px] uppercase tracking-widest transition-all active:scale-95 flex items-center gap-1.5" title="Rechazar">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    Rechazar
                                                </button>
                                            </form>
                                        @elseif($prestamo->estado == 'Activo')
                                            <button onclick="abrirModalDevolucion('{{ $prestamo->id }}', '{{ $prestamo->elemento->nombre }}')" 
                                                    class="p-1 px-3 rounded-lg font-black text-[9px] uppercase tracking-widest transition-all shadow-sm active:scale-95 flex items-center gap-1.5 {{ $esVencido ? 'bg-rose-600 text-white hover:bg-rose-700' : 'bg-slate-800 text-white hover:bg-black' }}">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 15L12 19M12 19L8 15M12 19V9M5 20H19"/></svg>
                                                Recibir
                                            </button>
                                        @elseif($prestamo->estado == 'Por Confirmar')
                                            <form action="{{ route('admin.prestamos.confirmar', $prestamo) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1 px-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-black text-[9px] uppercase tracking-widest transition-all shadow-sm active:scale-95 flex items-center gap-1.5" title="Confirmar Devolución">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    Confirmar
                                                </button>
                                            </form>
                                        @endif

                                        <div class="h-4 w-[1px] bg-slate-100 mx-0.5"></div>

                                        <a href="{{ route('admin.prestamos.edit', $prestamo) }}"
                                           class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all border border-blue-100 hover:border-blue-600 shadow-sm active:scale-90"
                                           title="Editar">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>

                                        <form id="loan-delete-{{ $prestamo->id }}" action="{{ route('admin.prestamos.destroy', $prestamo) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" 
                                                    onclick="confirmDelete('loan-delete-{{ $prestamo->id }}', '¿Deseas eliminar este registro del historial?')"
                                                    class="p-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg transition-all border border-rose-100 hover:border-rose-600 shadow-sm active:scale-90"
                                                    title="Eliminar">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-10 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest leading-loose">No hay operaciones registradas.</p>
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

    <!-- Modal de Devolución Premium -->
    <div id="modalDevolucion" class="fixed inset-0 z-[110] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all border border-slate-100">
            <div class="h-2 bg-gradient-to-r from-[#39A900] to-[#00324D]"></div>
            <div class="p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-emerald-50 rounded-2xl">
                        <svg class="w-6 h-6 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15L12 19M12 19L8 15M12 19V9M5 20H19"/></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-[#00324D] leading-tight">Reingreso de Equipo</h3>
                        <p id="txtElemento" class="text-[10px] font-black text-[#39A900] uppercase tracking-widest mt-0.5"></p>
                    </div>
                </div>
                
                <form id="formFinalizar" method="POST">
                    @csrf
                    <div class="mb-6 space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Observaciones de Entrega</label>
                        <textarea name="observaciones" rows="4" 
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-[13px] font-medium text-[#00324D] focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none placeholder:text-slate-300 resize-none leading-relaxed" 
                                placeholder="Describe el estado en el que se recibe el equipo..."></textarea>
                    </div>
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="w-full py-4 bg-[#00324D] text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-[#002538] shadow-lg shadow-[#00324D]/20 transition-all hover:scale-[1.02] active:scale-95">
                            Confirmar Devolución
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
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }
        function cerrarModal() {
            document.getElementById('modalDevolucion').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</x-admin-layout>

