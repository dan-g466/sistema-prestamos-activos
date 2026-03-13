<x-admin-layout>
    {{-- Header --}}
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 hidden sm:block">
                <svg class="w-6 h-6 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-[#00324D] dark:text-white leading-tight tracking-tight">
                    Modificar <span class="text-[#39A900]">Sanción</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-[10px] uppercase font-black tracking-widest mt-1">
                    Control de Sanciones <span class="mx-2 text-slate-300 dark:text-slate-700">|</span> Folio #{{ $sancion->id }}
                </p>
            </div>
        </div>
        {{-- Back Button --}}
        <a href="{{ route('admin.sanciones.index') }}"
           class="flex items-center gap-2 text-slate-400 dark:text-slate-500 hover:text-[#00324D] dark:hover:text-white transition-colors group">
            <div class="p-2 rounded-xl bg-slate-50 dark:bg-slate-800 group-hover:bg-slate-100 dark:group-hover:bg-slate-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest hidden sm:block">Volver</span>
        </a>
    </div>

    <div class="max-w-2xl mx-auto pb-8">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">

            {{-- Profile Banner --}}
            <div class="bg-gradient-to-r from-[#39A900] to-green-500 px-8 py-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-white font-black text-xl uppercase border border-white/30 shadow-lg shadow-green-900/10">
                    {{ strtoupper(substr(optional($sancion->user)->name ?? 'U', 0, 2)) }}
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/70">Usuario Sena sancionado</p>
                    <p class="font-black text-white text-base leading-none mt-1">{{ optional($sancion->user)->name ?? 'Usuario eliminado' }}</p>
                    <p class="text-[9px] text-white/60 font-black uppercase tracking-wider mt-1.5">{{ optional($sancion->user)->documento ?? '—' }}</p>
                </div>
                <span class="ml-auto text-[10px] font-black px-4 py-1.5 rounded-full bg-white text-[#39A900] shadow-xl uppercase tracking-widest">
                    {{ $sancion->fecha_fin >= now() ? 'Activa' : 'Expirada' }}
                </span>
            </div>

            {{-- Alert Note --}}
            <div class="mx-8 mt-8 p-5 bg-green-50 dark:bg-green-900/10 border border-green-100 dark:border-green-800/30 rounded-2xl flex items-start gap-4">
                <div class="w-8 h-8 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-black uppercase tracking-tight text-[#00324D] dark:text-slate-300 leading-relaxed">
                    Está modificando un <span class="text-[#39A900]">registro de sanción</span>. Los cambios tendrán efecto inmediato sobre el acceso al sistema.
                </p>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.sanciones.update', ['sancion' => $sancion]) }}" method="POST" class="p-8">
                @csrf @method('PUT')

                <div class="space-y-5">
                    {{-- Motivo --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 ml-1 mb-2" for="motivo">
                            Motivo / Descripción
                        </label>
                        <textarea id="motivo" name="motivo" rows="4" required
                                  class="w-full px-5 py-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-[#00324D] dark:text-white text-sm font-bold placeholder-slate-300 dark:placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-[#39A900] focus:border-transparent transition-all resize-none">{{ old('motivo', $sancion->motivo) }}</textarea>
                        @error('motivo')
                            <p class="mt-1.5 text-[9px] font-black uppercase tracking-widest text-red-500 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fechas --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2" for="fecha_inicio">
                                <svg class="w-3 h-3 inline mr-1 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Fecha de Inicio
                            </label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" required
                                   value="{{ old('fecha_inicio', optional($sancion->fecha_inicio)->format('Y-m-d')) }}"
                                   class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-[#00324D] dark:text-white text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#39A900] focus:border-transparent transition-all">
                            @error('fecha_inicio')
                                <p class="mt-1.5 text-[10px] font-bold text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2" for="fecha_fin">
                                <svg class="w-3 h-3 inline mr-1 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Fecha de Expiración
                            </label>
                            <input type="date" id="fecha_fin" name="fecha_fin" required
                                   value="{{ old('fecha_fin', optional($sancion->fecha_fin)->format('Y-m-d')) }}"
                                   class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-[#00324D] dark:text-white text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#39A900] focus:border-transparent transition-all">
                            @error('fecha_fin')
                                <p class="mt-1.5 text-[10px] font-bold text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-12 flex items-center justify-between gap-4">
                    <a href="{{ route('admin.sanciones.index') }}"
                       class="flex items-center gap-2 px-6 py-3 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 dark:hover:bg-slate-700 transition-all border border-slate-200 dark:border-slate-700 active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        Cancelar
                    </a>
                    <button type="submit"
                            class="flex items-center gap-2 px-10 py-3 bg-[#39A900] text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#2d8500] transition-all shadow-xl shadow-green-900/20 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>