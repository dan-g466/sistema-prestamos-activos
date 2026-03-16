<x-user-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-in fade-in slide-in-from-top-4 duration-700">
        
        {{-- Cabecera de Sección --}}
        <div class="mb-8 flex flex-col items-center text-center">
            <h2 class="text-3xl font-black text-[#00324D] dark:text-white tracking-tighter uppercase mb-2">
                Estado de mi <span class="text-[#39A900] dark:text-emerald-400">Cuenta</span>
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs max-w-lg font-medium">Revisa el historial de tus sanciones y verifica si tienes permisos para realizar nuevas solicitudes en el catálogo.</p>
        </div>

        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-2xl shadow-slate-200/50 dark:shadow-none sm:rounded-[2.5rem] p-8 border-t-[12px] border dark:border-slate-800 {{ Auth::user()->sancionado ? 'border-t-rose-500 dark:border-t-rose-600' : 'border-t-[#39A900] dark:border-t-emerald-500' }} transition-all duration-300">
            
            <div class="text-center mb-10 pb-8 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-xl font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest mb-6">Estado Actual</h3>
                @if(Auth::user()->sancionado)
                    <div class="inline-flex flex-col items-center">
                        <span class="px-6 py-2.5 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-900/30 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center gap-2 shadow-inner">
                            <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                            Solicitudes Bloqueadas
                        </span>
                        <p class="mt-4 text-xs text-rose-500 dark:text-rose-400 font-bold max-w-sm">No puedes apartar elementos en el catálogo hasta que expire tu sanción activa.</p>
                    </div>
                @else
                    <div class="inline-flex flex-col items-center">
                        <span class="px-6 py-2.5 bg-[#39A900]/10 dark:bg-emerald-900/20 text-[#39A900] dark:text-emerald-400 border border-[#39A900]/20 dark:border-emerald-900/30 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center gap-2 shadow-inner">
                            <span class="w-2 h-2 rounded-full bg-[#39A900] dark:bg-emerald-500 animate-pulse"></span>
                            Usuario al Día
                        </span>
                        <p class="mt-4 text-xs text-slate-500 dark:text-slate-400 font-medium max-w-sm">Tu cuenta está habilitada para solicitar equipos en el Sistema de Préstamos SENA.</p>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4 flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Registro de Sanciones
                </h4>
                
                @forelse($sanciones as $s)
                    <div class="p-6 rounded-3xl transition-all duration-300 hover:shadow-lg {{ $s->fecha_fin >= now() ? 'bg-rose-50/50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-900/20 hover:shadow-rose-100 dark:hover:shadow-none' : 'bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800' }}">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4 gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $s->fecha_fin >= now() ? 'text-rose-600 dark:text-rose-400 bg-white dark:bg-rose-900/30 border-rose-200 dark:border-rose-800' : 'text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700' }}">
                                @if($s->fecha_fin >= now())
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                @endif
                                {{ $s->fecha_fin >= now() ? 'Sanción Vigente' : 'Sanción Cumplida' }}
                            </span>
                            <span class="text-[10px] font-mono font-bold text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-900 px-2 py-1 rounded-md border border-slate-100 dark:border-slate-800 w-fit">Registrado: {{ $s->created_at->format('d/m/Y') }}</span>
                        </div>
                        <p class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed mb-6 bg-white dark:bg-slate-900/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800/50 font-medium">
                            <strong class="text-[#00324D] dark:text-slate-100 font-black block text-xs uppercase tracking-widest mb-1">Motivo:</strong> 
                            "{{ $s->motivo }}"
                        </p>
                        <div class="flex justify-between items-end border-t border-slate-200 dark:border-slate-700/50 pt-4">
                            <div class="flex flex-col">
                                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest mb-0.5">Inició:</span>
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">{{ $s->fecha_inicio->format('d/m/Y') }}</span>
                            </div>
                            <div class="text-right flex flex-col">
                                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest mb-0.5">Finaliza el:</span>
                                <span class="text-sm font-black {{ $s->fecha_fin >= now() ? 'text-rose-600 dark:text-rose-400' : 'text-[#39A900] dark:text-emerald-500' }}">{{ $s->fecha_fin->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-slate-50 dark:bg-slate-800/30 rounded-3xl border border-slate-100 dark:border-slate-800 border-dashed">
                        <div class="w-16 h-16 bg-[#39A900]/10 dark:bg-emerald-900/30 text-[#39A900] dark:text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-[#00324D] dark:text-white font-black text-lg mb-1">Registro Limpio</p>
                        <p class="text-slate-400 dark:text-slate-500 text-xs font-medium">No tienes antecedentes disciplinarios. ¡Sigue así!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-user-layout>