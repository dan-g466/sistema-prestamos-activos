<x-admin-layout>
    @php
        $estadoConfig = match($prestamo->estado) {
            'Pendiente' => ['bg' => 'from-amber-400 to-amber-500', 'light' => 'bg-amber-50', 'text' => 'text-amber-600', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'], // Ambar suave para solicitud
            'Aceptado'  => ['bg' => 'from-[#39A900]/80 to-[#39A900]', 'light' => 'bg-green-50', 'text' => 'text-[#39A900]', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'], // Verde medio para trámite
            'Activo'    => ['bg' => 'from-[#39A900] to-[#39A900]', 'light' => 'bg-green-50', 'text' => 'text-[#39A900]', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'], // Verde puro institucional para préstamo activo
            'Devuelto'  => ['bg' => 'from-[#39A900] to-[#2E7D32]', 'light' => 'bg-green-50', 'text' => 'text-[#39A900]', 'icon' => 'M5 13l4 4L19 7'], // Verde institucional para devuelto
            'Rechazado' => ['bg' => 'from-rose-500 to-rose-600', 'light' => 'bg-rose-50', 'text' => 'text-rose-600', 'icon' => 'M6 18L18 6M6 6l12 12'],
            default     => ['bg' => 'from-slate-400 to-slate-500', 'light' => 'bg-slate-50', 'text' => 'text-slate-600', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']
        };
        $esVencido = $prestamo->estado === 'Activo' && $prestamo->fecha_devolucion_esperada->isPast();
        if($esVencido) {
            // Mantenemos el fondo verde institucional pero usamos alertas en texto/iconos
            $estadoConfig['text'] = 'text-rose-600';
            $estadoConfig['icon_color'] = 'text-rose-200';
        }
    @endphp

    {{-- Breadcrumbs & Header Compact --}}
    <div class="mb-4 flex flex-col md:flex-row md:items-center justify-between gap-2">
        <div>
            <nav class="flex items-center gap-1.5 text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">
                <a href="{{ route('admin.prestamos.index') }}" class="hover:text-[#39A900] transition-colors">Préstamos</a>
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                <span class="text-[#39A900]">#{{ $prestamo->id }}</span>
            </nav>
            <h2 class="text-xl font-black text-slate-900 tracking-tighter uppercase leading-none">Detalle <span class="text-[#39A900]">Préstamo</span></h2>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.prestamos.index') }}" class="px-4 py-2 bg-white border border-slate-100 text-slate-900 text-[9px] font-black uppercase tracking-widest rounded-lg hover:bg-slate-50 shadow-sm transition-all active:scale-95">
                Volver
            </a>
            <a href="{{ route('admin.prestamos.edit', $prestamo) }}" class="px-4 py-2 bg-white border border-slate-100 text-[#39A900] text-[9px] font-black uppercase tracking-widest rounded-lg hover:bg-green-50 shadow-sm transition-all active:scale-95 flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar
            </a>
        </div>
    </div>

    {{-- Status Hero Banner Compact --}}
    <div class="relative overflow-hidden bg-gradient-to-r {{ $estadoConfig['bg'] }} rounded-2xl p-4 mb-4 shadow-lg">
        <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
        <div class="relative z-10 flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="h-10 w-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white ring-1 ring-white/20 shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $estadoConfig['icon'] }}"/></svg>
                </div>
                <div>
                    <p class="text-white/70 text-[8px] font-black uppercase tracking-[0.2em] leading-none mb-1">Estado</p>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-black text-white uppercase tracking-wider leading-none">{{ $prestamo->estado }}</span>
                        @if($esVencido)
                            <span class="px-2 py-0.5 bg-white text-rose-600 rounded-full text-[8px] font-black animate-pulse shadow-md whitespace-nowrap leading-none">⚠ VENCIDO</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-right">
                <p class="text-white/70 text-[8px] font-black uppercase tracking-[0.2em] leading-none mb-1">ID</p>
                <p class="text-lg font-black text-white leading-none">#{{ $prestamo->id }}</p>
            </div>
        </div>
    </div>

    {{-- Main Activity Grid Compact --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        
        {{-- Column 1: The Actors --}}
        <div class="space-y-4">
            {{-- Solicitante --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 group">
                <h3 class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span>
                    Solicitante
                </h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-[#39A900] to-green-800 flex items-center justify-center text-white font-black text-sm shrink-0">
                        {{ strtoupper(substr($prestamo->user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-black text-slate-900 leading-tight mb-0.5 truncate">{{ $prestamo->user->name }}</p>
                        <p class="text-[9px] font-bold text-slate-400 truncate">{{ $prestamo->user->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 bg-slate-50/50 rounded-xl p-3 border border-slate-50">
                    <div class="flex flex-col">
                        <span class="text-[7px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Documento</span>
                        <span class="text-[10px] font-bold text-slate-900">{{ $prestamo->user->documento }}</span>
                    </div>
                    <div class="flex flex-col text-right">
                        <span class="text-[7px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Celular</span>
                        <span class="text-[10px] font-bold text-slate-900">{{ $prestamo->user->telefono ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            {{-- Elemento --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 group">
                <h3 class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#39A900]"></span>
                    Elemento
                </h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-10 w-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center overflow-hidden shrink-0 shadow-inner">
                        @if($prestamo->elemento->imagen)
                            <img src="{{ asset('storage/' . $prestamo->elemento->imagen) }}" class="w-full h-full object-contain p-1.5">
                        @else
                            <svg class="w-5 h-5 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-black text-slate-900 leading-tight mb-0.5 truncate uppercase">{{ $prestamo->elemento->nombre }}</p>
                        <p class="text-[8px] font-black text-[#39A900] bg-green-50 px-1.5 py-0.5 rounded w-fit uppercase tracking-widest">{{ $prestamo->elemento->categoria->nombre }}</p>
                    </div>
                </div>
                <div class="bg-green-50/30 rounded-xl p-3 border border-green-50/50">
                    <div class="flex justify-between items-center">
                        <span class="text-[7px] font-black text-[#39A900] uppercase tracking-widest">Placa SENA</span>
                        <span class="text-[10px] font-mono font-black text-slate-900">{{ $prestamo->elemento->codigo_sena }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Column 2: Timeline Compact --}}
        <div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 h-full">
                <h3 class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                    <span class="w-4 h-[1px] bg-[#39A900]"></span>
                    {{ in_array($prestamo->estado, ['Pendiente', 'Rechazado']) ? 'Flujo de Solicitud' : 'Seguimiento de Préstamo' }}
                </h3>
                
                <div class="space-y-4 relative">
                    <div class="absolute left-[7px] top-1.5 bottom-4 w-[1px] bg-slate-100"></div>

                    {{-- Punto 1: Solicitud --}}
                    <div class="relative pl-6">
                        <div class="absolute left-0 top-1 h-3.5 w-3.5 rounded-full bg-white border border-slate-200 flex items-center justify-center z-10">
                            <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                        </div>
                        <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest leading-none mb-0.5">Solicitud</p>
                        <p class="text-[10px] font-bold text-slate-900">
                            {{ $prestamo->fecha_solicitud->timezone('America/Bogota')->format('d/m/y - h:i A') }}
                        </p>
                    </div>

                    {{-- Punto 2: Entrega / Recogida --}}
                    <div class="relative pl-6">
                        @php $tieneEntrega = !empty($prestamo->fecha_inicio); @endphp
                        <div class="absolute left-0 top-1 h-3.5 w-3.5 rounded-full bg-white border {{ $tieneEntrega ? 'border-[#39A900]' : 'border-slate-100 bg-slate-50' }} flex items-center justify-center z-10">
                            <div class="w-1 h-1 rounded-full {{ $tieneEntrega ? 'bg-[#39A900]' : 'bg-slate-200' }}"></div>
                        </div>
                        <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest leading-none mb-0.5">
                            {{ $prestamo->estado === 'Pendiente' ? 'Pase por el equipo' : 'Entrega' }}
                        </p>
                        <p class="text-[10px] font-bold {{ $tieneEntrega ? 'text-slate-900' : 'text-slate-400' }}">
                            @if($tieneEntrega)
                                {{ $prestamo->fecha_inicio->timezone('America/Bogota')->format('d/m/y - h:i A') }}
                            @else
                                {{ $prestamo->estado === 'Pendiente' ? 'Pendiente de aprobación' : 'No reportada' }}
                            @endif
                        </p>
                    </div>

                    {{-- Punto 3: Límite / Entrega Estimada --}}
                    <div class="relative pl-6">
                        <div class="absolute left-0 top-1 h-3.5 w-3.5 rounded-full bg-white border {{ $esVencido ? 'border-rose-500 animate-pulse' : 'border-[#39A900]/30' }} flex items-center justify-center z-10">
                            <div class="w-1 h-1 rounded-full {{ $esVencido ? 'bg-rose-600' : 'bg-[#39A900]' }}"></div>
                        </div>
                        <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest leading-none mb-0.5">
                            {{ $prestamo->estado === 'Pendiente' ? 'Entrega Estimada' : 'Límite de Devolución' }}
                        </p>
                        <p class="text-[10px] font-bold {{ $esVencido ? 'text-rose-600' : 'text-slate-900' }}">
                            {{ $prestamo->fecha_devolucion_esperada ? $prestamo->fecha_devolucion_esperada->timezone('America/Bogota')->format('d/m/y - h:i A') : 'N/A' }}
                        </p>
                    </div>

                    {{-- Punto 4: Reingreso --}}
                    <div class="relative pl-6">
                        @php $tieneDevolucion = !empty($prestamo->fecha_devolucion_real); @endphp
                        <div class="absolute left-0 top-1 h-3.5 w-3.5 rounded-full bg-white border {{ $tieneDevolucion ? 'border-green-600' : 'border-slate-100 bg-slate-50' }} flex items-center justify-center z-10">
                            <div class="w-1 h-1 rounded-full {{ $tieneDevolucion ? 'bg-green-700' : 'bg-slate-200' }}"></div>
                        </div>
                        <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest leading-none mb-0.5">Reingreso</p>
                        <p class="text-[10px] font-bold {{ $tieneDevolucion ? 'text-green-800' : 'text-slate-400' }}">
                            @if($tieneDevolucion)
                                {{ \Carbon\Carbon::parse($prestamo->fecha_devolucion_real)->timezone('America/Bogota')->format('d/m/y - h:i A') }}
                            @else
                                {{ in_array($prestamo->estado, ['Pendiente', 'Aceptado']) ? 'Sin iniciar' : 'Pendiente' }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Column 3: Context & Meta Compact --}}
        <div class="space-y-4">
            {{-- Propósito --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                <h3 class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#39A900]"></span>
                    Propósito
                </h3>
                <p class="text-[10px] font-medium text-slate-600 leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-50 italic text-pretty">
                    {{ $prestamo->proposito ?? 'Sin propósito redactado.' }}
                </p>
            </div>

            {{-- Observaciones --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                <h3 class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#39A900]"></span>
                    Observaciones
                </h3>
                <div class="text-[10px] font-medium text-slate-500 leading-tight text-pretty">
                    {{ $prestamo->observaciones ?? 'Sin notas adicionales.' }}
                </div>
            </div>

            {{-- Auditoría --}}
            <div class="bg-[#39A900] rounded-2xl p-4 text-white shadow-lg overflow-hidden relative">
                <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-white/5 rounded-full"></div>
                <h3 class="text-[7px] font-black text-white/40 uppercase tracking-[0.2em] mb-3">Auditoría</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center text-[9px]">
                        <span class="font-black text-white/30 uppercase tracking-widest">Creación</span>
                        <span class="font-bold text-white/80">{{ $prestamo->created_at->format('d/m/y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[9px]">
                        <span class="font-black text-white/30 uppercase tracking-widest">Cambio</span>
                        <span class="font-bold text-white/80">{{ $prestamo->updated_at->format('d/m/y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Action Center Compact --}}
    @if(in_array($prestamo->estado, ['Pendiente', 'Aceptado', 'Activo']))
        <div class="bg-white border border-slate-100 rounded-2xl p-3 shadow-md flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-green-50 text-[#39A900] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none mb-0.5">Acciones</p>
                    <p class="text-[10px] font-black text-slate-900">Gestionar Operación</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                @if($prestamo->estado == 'Pendiente')
                    <form action="{{ route('admin.prestamos.aceptar', $prestamo) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-green-700 transition-all active:scale-95 shadow-lg shadow-green-100 flex items-center gap-1.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
                            Aprobar
                        </button>
                    </form>
                @endif

                @if($prestamo->estado == 'Aceptado')
                    <form action="{{ route('admin.prestamos.entregar', $prestamo) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-[#39A900] text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-green-700 transition-all active:scale-95 shadow-lg shadow-green-100 flex items-center gap-1.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 4v16m8-8H4"/></svg>
                            Entregar
                        </button>
                    </form>
                @endif

                @if($prestamo->estado == 'Activo')
                    <button onclick="abrirModalDevolucion('{{ $prestamo->id }}', '{{ $prestamo->elemento->nombre }}')" 
                            class="px-4 py-2 bg-[#39A900] text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-green-700 transition-all active:scale-95 shadow-lg flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M16 15L12 19M12 19L8 15M12 19V9M5 20H19"/></svg>
                        Recibir
                    </button>
                @endif

                @if(in_array($prestamo->estado, ['Pendiente', 'Aceptado']))
                    <form action="{{ route('admin.prestamos.rechazar', $prestamo) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-rose-50 text-rose-600 border border-rose-100 rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all active:scale-95 group">
                            Rechazar
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endif

    {{-- Modal Devolución Compact --}}
    <div id="modalDevolucion" class="fixed inset-0 z-[110] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden transform transition-all border border-slate-100">
            <div class="h-1.5 bg-[#39A900]"></div>
            <div class="p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="p-2 bg-emerald-50 rounded-xl">
                        <svg class="w-5 h-5 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M16 15L12 19M12 19L8 15M12 19V9M5 20H19"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 leading-none">Reingreso</h3>
                        <p id="txtElemento" class="text-[8px] font-black text-[#39A900] uppercase tracking-widest mt-1"></p>
                    </div>
                </div>
                
                <form id="formFinalizar" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Observaciones</label>
                        <textarea name="observaciones" rows="3" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-xs font-medium text-slate-900 focus:border-[#39A900] transition-all outline-none placeholder:text-slate-300 resize-none" 
                                placeholder="Estado de recibo..."></textarea>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <button type="submit" class="w-full py-3 bg-[#39A900] text-white rounded-xl font-black uppercase tracking-widest text-[9px] hover:bg-green-700 shadow-lg shadow-green-100 transition-all active:scale-95">
                            Cerrar Préstamo
                        </button>
                        <button type="button" onclick="cerrarModal()" class="w-full py-2.5 text-slate-400 font-black text-[9px] uppercase tracking-widest hover:text-slate-600">
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
