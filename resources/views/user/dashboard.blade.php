<x-user-layout>
    <div class="h-[calc(100vh-120px)] flex flex-col overflow-hidden">
        {{-- Banner de Bienvenida Estilo Vidrio (Glassmorphism Pro) --}}
        <div class="relative shrink-0 overflow-hidden bg-gradient-to-br from-[#39A900] via-[#39A900] to-[#39A900] rounded-[3rem] p-6 md:p-10 mb-8 shadow-[0_25px_80px_-20px_rgba(57,169,0,0.3)] animate-in fade-in slide-in-from-top-10 duration-1000 group">
            {{-- Elementos Orgánicos de Fondo --}}
            <div class="absolute -right-20 -top-20 w-[30rem] h-[30rem] bg-[#39A900]/10 rounded-full blur-[100px] mix-blend-screen animate-pulse"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 text-center md:text-left">
                    <div class="inline-flex items-center gap-3 px-3 py-1.5 bg-white/5 dark:bg-black/20 backdrop-blur-2xl rounded-2xl border border-white/10 mb-6 transform hover:scale-105 transition-transform cursor-default">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#39A900] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#39A900]"></span>
                        </span>
                        <span class="text-[9px] font-black text-white/90 uppercase tracking-[0.4em]">Plataforma SENA 4.0</span>
                        <div class="h-3 w-[1px] bg-white/10 mx-1"></div>
                        <span id="live-clock" class="text-[9px] font-black text-[#39A900] uppercase tracking-widest">
                            {{ now()->isoFormat('D [de] MMMM, YYYY') }} | <span id="clock-time">{{ now()->format('h:i:s A') }}</span>
                        </span>
                    </div>
                    
                    <h1 class="text-3xl md:text-5xl font-black text-white tracking-tighter leading-[0.9] mb-4">
                        ¡Hola, <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ffffff] to-[#ffffff]">{{ explode(' ', Auth::user()->name)[0] }}</span>!
                    </h1>
                    
                    <p class="text-white font-medium text-sm leading-relaxed max-w-xl mb-6 italic">
                        Gestiona tus recursos formativos con precisión. Todo lo que necesitas en una sola vista.
                    </p>
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-5">
                        <a href="{{ route('user.catalogo') }}" class="group relative px-6 py-3 bg-[#39A900] text-white rounded-xl font-black text-[10px] uppercase tracking-[0.2em] shadow-[0_15px_40px_-10px_rgba(57,169,0,0.5)] hover:shadow-[#39A900]/60 transition-all hover:-translate-y-1 active:scale-95 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            <span class="relative flex items-center gap-3">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                Nuevo Préstamo
                            </span>
                        </a>
                        
                        <div class="hidden md:flex items-center gap-4 px-5 border-l border-white/10">
                            <div class="text-center">
                                <p class="text-[8px] font-black text-white/40 uppercase mb-0.5">Activos</p>
                                <p class="text-xl font-black text-white leading-none">{{ $prestamosActivos->count() }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-[8px] font-black text-white/40 uppercase mb-0.5">Trámite</p>
                                <p class="text-xl font-black text-white leading-none">{{ $solicitudes->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card de Usuario Compacta --}}
                <div class="relative group/user shrink-0">
                    <div class="relative bg-white/5 dark:bg-black/20 backdrop-blur-3xl border border-white/10 rounded-[2.5rem] p-6 flex flex-col items-center gap-4 shadow-2xl transition-transform group-hover/user:-translate-y-1">
                        <div class="w-16 h-16 bg-gradient-to-br from-white to-slate-200 dark:from-slate-700 dark:to-slate-900 rounded-2xl shadow-2xl flex items-center justify-center text-2xl font-black text-[#00324D] dark:text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="text-center">
                            <h4 class="text-sm font-black text-white tracking-tight leading-tight">{{ Auth::user()->name }}</h4>
                            <span class="text-[8px] font-black text-[#ffffff] uppercase tracking-[0.3em]">Gestión {{ date('Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid de Gestión Principal con Scroll Interno Controlado --}}
        <div class="flex-1 min-h-0 grid grid-cols-1 lg:grid-cols-12 gap-8 animate-in fade-in slide-in-from-bottom-12 duration-1000 delay-500">
            
            {{-- Columna: PRÉSTAMOS ACTIVOS --}}
            <div class="lg:col-span-12 xl:col-span-8 flex flex-col min-h-0">
                <div class="flex items-center justify-between mb-6 shrink-0">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white dark:bg-slate-800 rounded-2xl shadow-lg flex items-center justify-center text-[#39A900] border border-slate-50 dark:border-slate-700">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="text-xl font-black text-[#00324D] dark:text-white tracking-tighter uppercase">Equipos en uso</h3>
                    </div>
                    <a href="{{ route('user.prestamos.activos') }}" class="px-4 py-1.5 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-full text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest hover:text-[#39A900] transition-all">Ver Más</a>
                </div>

                <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-4">
                    @forelse($prestamosActivos as $p)
                        <div class="group relative bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-4 rounded-3xl shadow-xl shadow-slate-200/30 dark:shadow-none hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-4">
                             <div class="flex items-center gap-4 relative z-10">
                                <div class="w-12 h-12 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-[#39A900] shadow-inner group-hover:scale-105 transition-transform duration-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-black text-[#00324D] dark:text-white group-hover:text-[#39A900] transition-colors tracking-tight">{{ $p->elemento->nombre }}</h4>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[8px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none">Placa:</span>
                                        <span class="text-[9px] font-mono font-bold text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 px-2 py-0.5 rounded border border-slate-100 dark:border-slate-700">{{ $p->elemento->codigo_sena }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-6 relative z-10">
                                <div class="hidden md:flex flex-col items-end">
                                    <span class="text-[8px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-0.5">Entrega:</span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[11px] font-black text-rose-500">{{ $p->fecha_devolucion_esperada ? $p->fecha_devolucion_esperada->format('d/m') : '—' }}</span>
                                        <span class="px-1.5 py-0.5 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded text-[8px] font-black uppercase">{{ $p->fecha_devolucion_esperada ? $p->fecha_devolucion_esperada->format('h:i A') : '' }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('user.prestamos.show', $p) }}" class="flex items-center gap-2 px-4 py-2.5 bg-[#00324D] text-white rounded-xl text-[8px] font-black uppercase tracking-widest hover:bg-[#39A900] transition-all shrink-0">
                                    Seguimiento
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 bg-slate-50/30 dark:bg-slate-900/30 border-4 border-dashed border-slate-100 dark:border-slate-800 rounded-[2.5rem] text-center">
                            <p class="text-[9px] font-black text-slate-300 dark:text-slate-700 uppercase tracking-[0.3em]">Sin capturas activas</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Columna Lateral: SOLICITUDES --}}
            <div class="lg:col-span-12 xl:col-span-4 flex flex-col min-h-0">
                <div class="flex items-center justify-between mb-6 shrink-0">
                    <h3 class="text-xl font-black text-[#00324D] dark:text-white tracking-tighter uppercase">Pendientes</h3>
                    <a href="{{ route('user.prestamos.index') }}" class="text-[9px] font-black text-amber-500 uppercase tracking-widest hover:underline">Gestionar</a>
                </div>

                <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-3">
                    @forelse($solicitudes as $s)
                        <div class="group bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-4 rounded-3xl shadow-xl shadow-slate-200/10 dark:shadow-none hover:shadow-2xl transition-all duration-500 relative flex items-center gap-4">
                            <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/10 rounded-xl flex items-center justify-center text-amber-500 dark:text-amber-400 shrink-0 shadow-inner group-hover:rotate-6 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-[12px] font-black text-[#00324D] dark:text-white truncate group-hover:text-amber-600 transition-colors tracking-tight">{{ $s->elemento->nombre }}</h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="px-1.5 py-0.5 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded text-[7px] font-black uppercase tracking-tighter border border-amber-100 dark:border-amber-900/30">{{ $s->estado }}</span>
                                    <span class="text-[7px] font-black text-slate-300 dark:text-slate-600 uppercase leading-none">{{ $s->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                             <a href="{{ route('user.prestamos.show', $s) }}" class="w-8 h-8 border border-slate-100 dark:border-slate-800 rounded-lg flex items-center justify-center text-slate-300 dark:text-slate-700 hover:text-amber-500 dark:hover:text-amber-400 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    @empty
                        <div class="py-8 bg-white dark:bg-slate-900 rounded-[2rem] border border-dashed border-slate-100 dark:border-slate-800 text-center">
                            <p class="text-[8px] font-black text-slate-300 dark:text-slate-700 uppercase tracking-[0.3em]">Vacío</p>
                        </div>
                    @endforelse
                </div>

                {{-- Alert Sanción --}}
                @if(Auth::user()->sancionado)
                    <div class="mt-6 shrink-0 bg-gradient-to-br from-rose-500 to-rose-700 rounded-[2.5rem] p-6 text-white shadow-2xl relative overflow-hidden">
                        <h5 class="text-[10px] font-black uppercase tracking-widest mb-1 flex items-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                             Sanción Activa
                        </h5>
                        <a href="{{ route('user.sanciones.index') }}" class="block w-full py-3 mt-3 bg-white text-rose-600 rounded-xl text-[8px] font-black uppercase tracking-widest text-center shadow-xl">Ver Expediente</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-user-layout>

<script>
    function updateClock() {
        const now = new Date();
        const options = { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit', 
            hour12: true 
        };
        const timeString = now.toLocaleTimeString('en-US', options);
        document.getElementById('clock-time').textContent = timeString;
    }
    setInterval(updateClock, 1000);
</script>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 4s infinite ease-in-out;
    }
</style>