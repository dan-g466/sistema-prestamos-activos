<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h2 class="font-black text-3xl text-gray-800 dark:text-white leading-tight tracking-tight">
                {{ __('Admin Dashboard') }} <span class="text-[#39A900]">SENA</span>
            </h2>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 mt-1">Control de Inventario y Préstamos</p>
        </div>
        <div class="text-[10px] font-black uppercase tracking-widest text-[#39A900] bg-white dark:bg-slate-900 border border-[#39A900]/10 dark:border-slate-800 px-6 py-3 rounded-2xl shadow-sm flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[#39A900] animate-pulse"></span>
            {{ now()->timezone('America/Bogota')->translatedFormat('d \d\e F, Y') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white dark:bg-slate-900 border-l-4 border-[#39A900] shadow-sm dark:shadow-none border dark:border-slate-800 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[9px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Inventario Total</p>
                    <p class="text-4xl font-black text-gray-800 dark:text-white group-hover:text-[#39A900] transition-colors tracking-tight">{{ $totalElementos }}</p>
                </div>
                <div class="p-4 bg-[#39A900]/5 dark:bg-[#39A900]/10 rounded-2xl text-[#39A900] group-hover:bg-[#39A900] group-hover:text-white transition-all duration-300 shadow-sm border border-[#39A900]/5 dark:border-white/5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 border-l-4 border-amber-500 shadow-sm dark:shadow-none border dark:border-slate-800 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[9px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Por Aprobar</p>
                    <p class="text-4xl font-black text-gray-800 dark:text-white group-hover:text-amber-500 transition-colors tracking-tight">{{ $prestamosPendientes }}</p>
                </div>
                <div class="p-4 bg-amber-50 dark:bg-amber-900/10 rounded-2xl text-amber-600 dark:text-amber-400 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 shadow-sm border border-amber-200 dark:border-white/5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 border-l-4 border-emerald-500 shadow-sm dark:shadow-none border dark:border-slate-800 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[9px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Equipos Prestados</p>
                    <p class="text-4xl font-black text-gray-800 dark:text-white group-hover:text-emerald-500 transition-colors tracking-tight">{{ $prestamosActivos }}</p>
                </div>
                <div class="p-4 bg-emerald-50 dark:bg-emerald-900/10 rounded-2xl text-emerald-600 dark:text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300 shadow-sm border border-emerald-200 dark:border-white/5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 border-l-4 border-rose-500 shadow-sm dark:shadow-none border dark:border-slate-800 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[9px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Sancionados</p>
                    <p class="text-4xl font-black text-gray-800 dark:text-white group-hover:text-rose-500 transition-colors tracking-tight">{{ $usuariosSancionados }}</p>
                </div>
                <div class="p-4 bg-rose-50 dark:bg-rose-900/10 rounded-2xl text-rose-600 dark:text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300 shadow-sm border border-rose-200 dark:border-white/5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm p-8 md:p-12 border border-slate-100 dark:border-slate-800 transition-all">
        <h3 class="text-2xl font-black text-gray-800 dark:text-white mb-10 flex items-center gap-4">
            <div class="w-12 h-12 bg-[#39A900] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-900/10">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
            </div>
            Gestión de Préstamos
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('admin.elementos.create') }}" class="flex flex-col items-center p-8 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-[2rem] hover:bg-[#39A900] dark:hover:bg-[#39A900] hover:text-white transition-all duration-500 group shadow-sm hover:shadow-2xl hover:-translate-y-2">
                <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:bg-white transition-all duration-500">
                    <svg class="w-8 h-8 text-[#39A900] group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#39A900] group-hover:text-white/90">Nuevo Equipo</span>
            </a>
            <a href="{{ route('admin.prestamos.index') }}" class="flex flex-col items-center p-8 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-[2rem] hover:bg-[#39A900] dark:hover:bg-[#39A900] hover:text-white transition-all duration-500 group shadow-sm hover:shadow-2xl hover:-translate-y-2">
                <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:bg-white transition-all duration-500">
                    <svg class="w-8 h-8 text-[#39A900] group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#39A900] group-hover:text-white/90">Solicitudes</span>
            </a>
            <a href="{{ route('admin.reportes.index') }}" class="flex flex-col items-center p-8 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-[2rem] hover:bg-[#39A900] dark:hover:bg-[#39A900] hover:text-white transition-all duration-500 group shadow-sm hover:shadow-2xl hover:-translate-y-2">
                <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:bg-white transition-all duration-500">
                    <svg class="w-8 h-8 text-[#39A900] group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H5a2 2 0 01-2-2V5a2 2 0 012-2h11.282a1 1 0 01.707.293l2.424 2.424a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#39A900] group-hover:text-white/90">Reportes</span>
            </a>
            <a href="{{ route('admin.backups.index') }}" class="flex flex-col items-center p-8 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-[2rem] hover:bg-[#39A900] dark:hover:bg-[#39A900] hover:text-white transition-all duration-500 group shadow-sm hover:shadow-2xl hover:-translate-y-2">
                <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:bg-white transition-all duration-500">
                    <svg class="w-8 h-8 text-[#39A900] group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#39A900] group-hover:text-white/90">Seguridad</span>
            </a>
        </div>
    </div>
</x-admin-layout>
