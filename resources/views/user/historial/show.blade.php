<x-user-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Cabecera con Navegación Compacta --}}
        <div class="mb-8 flex items-center justify-between animate-in fade-in slide-in-from-top-4 duration-700">
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() }}" class="w-10 h-10 bg-white rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#39A900] hover:shadow-lg transition-all active:scale-95 group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-black text-[#00324D] tracking-tighter uppercase leading-none">Seguimiento</h2>
                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">Ticket: #PRE-{{ str_pad($prestamo->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-slate-100 shadow-sm">
                <div class="w-1.5 h-1.5 rounded-full bg-[#39A900] animate-pulse"></div>
                <span class="text-[9px] font-black text-[#00324D] uppercase tracking-widest">Estado: {{ $prestamo->estado }}</span>
            </div>
        </div>

        {{-- ─── BARRA DE PROGRESO HORIZONTAL PREMIUM ─── --}}
        <div class="mb-10 animate-in zoom-in-95 duration-1000">
            <div class="bg-white rounded-[2rem] p-8 shadow-2xl shadow-slate-200/40 border border-slate-100 relative overflow-hidden">
                {{-- Fondo suave --}}
                <div class="absolute inset-0 bg-gradient-to-r from-slate-50/50 to-transparent pointer-events-none"></div>
                
                <div class="relative">
                    @php
                        $pasos = [
                            ['id' => 'Pendiente',     'title' => 'Revisión',   'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                            ['id' => 'Aceptado',      'title' => 'Aprobado',   'icon' => 'M5 13l4 4L19 7'],
                            ['id' => 'Activo',        'title' => 'En Uso',     'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
                            ['id' => 'Por Confirmar', 'title' => 'Devuelto',   'icon' => 'M16 15L12 19M12 19L8 15M12 19V9M5 20H19'],
                            ['id' => 'Devuelto',      'title' => 'Historial',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ];
                        $currIdx = -1;
                        foreach($pasos as $i => $paso) if($prestamo->estado == $paso['id']) $currIdx = $i;
                        if($prestamo->estado == 'Rechazado') $currIdx = -2;
                        if($prestamo->estado == 'Vencido') $currIdx = 2;
                        $percent = $currIdx >= 0 ? ($currIdx / (count($pasos) - 1)) * 100 : 0;
                    @endphp

                    {{-- Línea de Progreso Horizontal --}}
                    <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-50 -translate-y-1/2 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#39A900] to-[#00324D] transition-all duration-1000 ease-out" style="width: {{ $percent }}%"></div>
                    </div>

                    {{-- Hitos --}}
                    <div class="flex justify-between relative z-10">
                        @foreach($pasos as $index => $paso)
                            @php
                                $isPast = $index < $currIdx;
                                $isCurrent = $index == $currIdx;
                                $isFuture = $index > $currIdx && $currIdx != -2;
                                
                                $circleBase = "w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-700 shadow-lg border-4 border-white";
                                if($isPast) $iconStyle = "$circleBase bg-[#39A900] text-white";
                                elseif($isCurrent) {
                                    $color = ($prestamo->estado == 'Por Confirmar') ? 'bg-indigo-600 ring-indigo-600/5' : 'bg-[#00324D] ring-[#00324D]/5';
                                    $iconStyle = "$circleBase $color text-white scale-110";
                                }
                                else $iconStyle = "$circleBase bg-white text-slate-200 border-slate-50";
                            @endphp

                            <div class="flex flex-col items-center gap-3">
                                <div class="{{ $iconStyle }}">
                                    @if($isCurrent)
                                        <div class="absolute -inset-1 bg-white/20 rounded-2xl animate-ping pointer-events-none"></div>
                                    @endif
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $paso['icon'] }}" /></svg>
                                </div>
                                <div class="text-center">
                                    <p class="text-[9px] font-black uppercase tracking-widest {{ $isCurrent ? ($prestamo->estado == 'Por Confirmar' ? 'text-indigo-600' : 'text-[#00324D]') : ($isPast ? 'text-[#39A900]' : 'text-slate-300') }}">
                                        {{ $paso['title'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($prestamo->estado == 'Rechazado')
                    <div class="mt-8 flex items-center justify-center gap-3 animate-bounce">
                        <span class="px-4 py-2 bg-rose-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-rose-200 flex items-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                             Solicitud No Aprobada
                        </span>
                    </div>
                @endif
            </div>
        </div>

        {{-- ─── DISTRIBUCIÓN MODULAR ─── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch mb-10">
            
            {{-- Bloque Izquierdo: El Equipo --}}
            <div class="animate-in fade-in slide-in-from-left-6 duration-1000 delay-200">
                <div class="bg-white h-full rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/40 border border-slate-100 flex items-center gap-8 group">
                    <div class="w-32 h-32 bg-[#fcfdf2] rounded-3xl border border-slate-50 p-6 flex items-center justify-center shadow-inner shrink-0 group-hover:scale-105 transition-transform duration-500">
                        @if($prestamo->elemento->imagen)
                            <img src="{{ asset('storage/' . $prestamo->elemento->imagen) }}" class="max-h-full max-w-full object-contain">
                        @else
                            <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        @endif
                    </div>
                    <div>
                        <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[8px] font-black uppercase tracking-[0.2em] rounded-md mb-2 inline-block">
                            {{ $prestamo->elemento->categoria->nombre }}
                        </span>
                        <h3 class="text-2xl font-black text-[#00324D] tracking-tight leading-tight mb-2">{{ $prestamo->elemento->nombre }}</h3>
                        <div class="flex items-center gap-3">
                             <span class="text-[10px] font-mono font-bold text-[#39A900] bg-[#39A900]/5 px-2 py-0.5 rounded border border-[#39A900]/10">{{ $prestamo->elemento->codigo_sena }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bloque Derecho: Tiempos --}}
            <div class="animate-in fade-in slide-in-from-right-6 duration-1000 delay-400">
                <div class="bg-[#00324D] h-full rounded-[2.5rem] p-8 shadow-2xl shadow-blue-900/20 relative overflow-hidden">
                    {{-- Decoración --}}
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 grid grid-cols-2 gap-6 h-full items-center">
                        <div class="flex flex-col gap-2">
                            <div class="w-10 h-10 bg-white/10 rounded-2xl flex items-center justify-center text-white/40">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-[8px] font-black text-[#39A900] uppercase tracking-[0.2em] mb-1">Inicio de Préstamo</p>
                                <p class="text-lg font-black text-white leading-none tracking-tight">
                                    {{ $prestamo->fecha_inicio ? $prestamo->fecha_inicio->format('d/m/Y') : 'Pendiente' }}
                                </p>
                                <p class="text-[10px] font-bold text-white/40 mt-1 uppercase">
                                    {{ $prestamo->fecha_inicio ? $prestamo->fecha_inicio->format('h:i A') : 'Por autorizar' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="w-10 h-10 bg-[#39A900]/30 rounded-2xl flex items-center justify-center text-[#39A900]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[8px] font-black text-[#39A900] uppercase tracking-[0.2em] mb-1">Entrega Esperada</p>
                                <p class="text-lg font-black text-white leading-none tracking-tight">
                                    {{ $prestamo->fecha_devolucion_esperada ? $prestamo->fecha_devolucion_esperada->format('d/m/Y') : 'Pendiente' }}
                                </p>
                                <p class="text-[10px] font-bold text-rose-500 mt-1 uppercase">
                                    {{ $prestamo->fecha_devolucion_esperada ? $prestamo->fecha_devolucion_esperada->format('h:i A') : 'Por autorizar' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Observaciones y Advertencia de Devolución --}}
            <div class="lg:col-span-2 space-y-6 animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-500">
                {{-- Advertencia Preventiva para Préstamos en Poder o en Confirmación --}}
                @if(in_array($prestamo->estado, ['Activo', 'Vencido', 'Por Confirmar']))
                    @php
                        $isConfirming = $prestamo->estado === 'Por Confirmar';
                        $bgColor = $isConfirming ? 'bg-indigo-50 border-indigo-200 shadow-indigo-900/5' : 'bg-amber-50 border-amber-200 shadow-amber-900/5';
                        $iconColor = $isConfirming ? 'bg-indigo-600' : 'bg-amber-500';
                        $textColor = $isConfirming ? 'text-indigo-600' : 'text-amber-600';
                        $mainTextColor = $isConfirming ? 'text-indigo-900' : 'text-amber-900';
                    @endphp
                    <div class="{{ $bgColor }} rounded-[2rem] p-6 border shadow-xl flex items-center gap-6 relative overflow-hidden group">
                        <div class="absolute right-0 top-0 w-32 h-full bg-gradient-to-l {{ $isConfirming ? 'from-indigo-100/50' : 'from-amber-100/50' }} to-transparent"></div>
                        <div class="w-12 h-12 {{ $iconColor }} rounded-2xl flex items-center justify-center text-white shadow-lg shrink-0 {{ !$isConfirming ? 'animate-pulse' : '' }}">
                            @if($isConfirming)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            @endif
                        </div>
                        <div class="z-10">
                            <p class="text-[10px] font-black {{ $textColor }} uppercase tracking-widest mb-1">
                                {{ $isConfirming ? 'Proceso de Devolución' : 'Recordatorio de Seguridad' }}
                            </p>
                            <p class="text-[12px] font-bold {{ $mainTextColor }} leading-relaxed">
                                @if($isConfirming)
                                    Has entregado los elementos. <strong>El administrador debe confirmar la recepción física</strong> para que el préstamo se mueva oficialmente a tu historial.
                                @else
                                    Por favor devolver el elemento en el tiempo estimado que se generó en la solicitud para que el administrador confirme la entrega y <span class="text-rose-600 underline decoration-rose-300">no sea sancionado</span>.
                                @endif
                            </p>
                        </div>
                    </div>
                @endif

                @if($prestamo->observaciones)
                    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-xl shadow-slate-200/20 flex items-center gap-6">
                        <div class="w-12 h-12 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-center text-[#39A900] shrink-0">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Observaciones del Administrador</p>
                            <p class="text-sm font-bold text-[#00324D] italic leading-relaxed">"{{ $prestamo->observaciones }}"</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-center pb-10">
             <a href="{{ route('user.catalogo') }}" class="group inline-flex items-center gap-3 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-[#39A900] transition-colors">
                <span class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100 transition-all group-hover:bg-[#39A900] group-hover:text-white group-hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </span>
                Volver a servicios
             </a>
        </div>
    </div>
</x-user-layout>
