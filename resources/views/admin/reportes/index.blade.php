<x-admin-layout>
    <div class="mb-8">
        <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight tracking-tight">
            {{ __('Centro de Reportes') }} <span class="text-[#39A900]">Estadísticas</span>
        </h2>
        <p class="text-slate-500 dark:text-slate-400 text-[10px] uppercase font-black tracking-widest mt-1">Análisis operativo del sistema</p>
    </div>
    <div>
        <div class="max-w-7xl mx-auto">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 text-center relative overflow-hidden group hover:shadow-xl transition-all duration-500">
                    <div class="absolute top-0 right-0 p-2 bg-indigo-50 dark:bg-indigo-900/10 rounded-bl-2xl text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4">Tasa de Uso</h4>
                    <p class="text-5xl font-black text-indigo-600 dark:text-indigo-400 tracking-tighter">{{ $usoPorcentaje }}%</p>
                    <p class="text-[9px] font-bold text-slate-400 dark:text-slate-600 mt-4 italic">Equipos fuera de bodega hoy</p>
                </div>

                <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 text-center relative overflow-hidden group hover:shadow-xl transition-all duration-500">
                    <div class="absolute top-0 right-0 p-2 bg-[#39A900]/5 dark:bg-[#39A900]/10 rounded-bl-2xl text-[#39A900] group-hover:bg-[#39A900] group-hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4">Top Equipo</h4>
                    <div class="flex flex-col items-center gap-1">
                        <p class="text-xl font-black text-slate-800 dark:text-white group-hover:text-[#39A900] transition-colors uppercase leading-none">{{ $topElemento->nombre ?? 'N/A' }}</p>
                        <p class="text-[9px] font-black text-[#39A900] dark:text-[#39A900]/80 bg-green-50 dark:bg-green-900/20 px-2.5 py-1 rounded-full uppercase tracking-widest mt-2">{{ $topElemento->prestamos_count ?? 0 }} préstamos totales</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 text-center relative overflow-hidden group hover:shadow-xl transition-all duration-500">
                    <div class="absolute top-0 right-0 p-2 bg-rose-50 dark:bg-rose-900/10 rounded-bl-2xl text-rose-500 group-hover:bg-rose-500 group-hover:text-white transition-all text-xs font-black uppercase">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4">Morosidad</h4>
                    <p class="text-5xl font-black text-rose-600 dark:text-rose-400 tracking-tighter">{{ $totalVencidos }}</p>
                    <p class="text-[9px] font-bold text-slate-400 dark:text-slate-600 mt-4 italic">Préstamos retrasados actualmente</p>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm rounded-[2.5rem] p-8 border border-slate-100 dark:border-slate-800">
                    <h3 class="font-black text-slate-800 dark:text-white mb-6 flex items-center gap-3">
                        <div class="p-2 bg-rose-50 dark:bg-rose-900/20 rounded-xl">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        Equipos Bloqueados
                    </h3>
                    <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($equiposFuera as $equipo)
                        <li class="py-4 flex flex-col gap-1 transition-all hover:translate-x-1 duration-300">
                            <span class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-tight">{{ $equipo->nombre }}</span>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-mono text-slate-400 dark:text-slate-500">{{ $equipo->codigo_sena }}</span>
                                <span class="px-2.5 py-0.5 text-[8px] font-black rounded-full uppercase tracking-widest border {{ $equipo->estado == 'Dado de Baja' ? 'bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 border-rose-100 dark:border-rose-900/30' : 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border-amber-100 dark:border-amber-900/30' }}">
                                    {{ $equipo->estado }}
                                </span>
                            </div>
                        </li>
                        @empty
                        <li class="py-10 text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-[0.2em] italic text-center">Todo el inventario está operativo</li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-[#39A900] overflow-hidden shadow-2xl shadow-[#39A900]/40 rounded-[2.5rem] p-10 text-white relative group border border-white/10">
                    {{-- Efecto de patrón abstracto sutil --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-[80px] -mr-32 -mt-32 pointer-events-none group-hover:bg-white/20 transition-all duration-700"></div>
                    
                    <div class="absolute top-0 right-0 p-8 opacity-20 group-hover:scale-110 transition-transform duration-700 rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" /></svg>
                    </div>
                    
                    <h3 class="text-2xl font-black mb-2 flex items-center gap-3 relative z-10 text-white">
                        <div class="p-2 bg-white/20 rounded-xl backdrop-blur-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        Descargar Reportes
                    </h3>
                    <p class="text-white/90 text-[10px] font-black uppercase tracking-[0.25em] mb-10 relative z-10 leading-tight">Documentación <span class="text-white">Oficial Administrativa</span></p>
                    
                    <div class="space-y-4 relative z-10">
                        <a href="{{ route('admin.reportes.pdf', ['tipo' => 'inventario']) }}" class="flex items-center justify-between p-5 bg-white/10 border border-white/10 rounded-2xl hover:bg-white hover:text-[#39A900] transition-all duration-500 group/link shadow-lg group-hover:shadow-[#39A900]/30">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center group-hover/link:bg-[#39A900]/10 transition-colors duration-500">
                                    <svg class="w-5 h-5 text-white group-hover/link:text-[#39A900]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0111 2.414l3.586 3.586a1 1 0 01.414.707V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em]">Inventario Completo</span>
                            </div>
                            <svg class="w-4 h-4 opacity-40 group-hover/link:opacity-100 group-hover/link:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('admin.reportes.pdf', ['tipo' => 'prestamos_mes']) }}" class="flex items-center justify-between p-5 bg-white/10 border border-white/10 rounded-2xl hover:bg-white hover:text-[#39A900] transition-all duration-500 group/link shadow-lg group-hover:shadow-[#39A900]/30">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center group-hover/link:bg-[#39A900]/10 transition-colors duration-500">
                                    <svg class="w-5 h-5 text-white group-hover/link:text-[#39A900]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em]">Préstamos del Mes</span>
                            </div>
                            <svg class="w-4 h-4 opacity-40 group-hover/link:opacity-100 group-hover/link:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>