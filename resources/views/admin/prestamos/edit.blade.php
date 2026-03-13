<x-admin-layout>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight tracking-tight">
                {{ __('Ajustar') }} <span class="text-[#39A900]">Registro de Operación</span>
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-[10px] uppercase font-black tracking-widest mt-1">
                Auditoría de Préstamos <span class="mx-2 text-slate-300 dark:text-slate-700">|</span> Folio #{{ $prestamo->id }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.prestamos.show', $prestamo) }}" 
               class="flex items-center gap-2 px-4 py-2 bg-slate-50 text-slate-600 rounded-xl hover:bg-slate-100 transition-all group border border-slate-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span class="text-[9px] font-black uppercase tracking-widest">Ver Detalle</span>
            </a>
            <a href="{{ route('admin.prestamos.index') }}" 
               class="flex items-center gap-2 text-slate-400 hover:text-slate-600 transition-colors group">
                <div class="p-2 rounded-xl bg-slate-50 group-hover:bg-slate-100 transition-colors border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest hidden md:block">Volver</span>
            </a>
        </div>
    </div>

    <div class="max-w-4xl">
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-[#39A900]"></div>
            
            <form action="{{ route('admin.prestamos.update', $prestamo) }}" method="POST" class="p-6 md:p-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Información No Editable --}}
                    <div class="space-y-1.5 opacity-60">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">Aprendiz Solicitante</label>
                        <div class="flex items-center gap-3 p-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl">
                            <div class="w-8 h-8 rounded-xl bg-white dark:bg-slate-900 flex items-center justify-center text-slate-400 dark:text-slate-600 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $prestamo->user->name }}</span>
                        </div>
                    </div>

                    <div class="space-y-1.5 opacity-60">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 ml-1">Elemento Técnico</label>
                        <div class="flex items-center gap-3 p-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl">
                            <div class="w-8 h-8 rounded-xl bg-white dark:bg-slate-900 flex items-center justify-center text-[#39A900] shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                            </div>
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $prestamo->elemento->nombre }}</span>
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="space-y-1.5">
                        <label for="estado" class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-600 dark:text-slate-400 ml-1">Estado de la Operación</label>
                        <div class="relative group/input">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-600 group-focus-within/input:text-[#39A900] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <select name="estado" id="estado" 
                                    class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-800 dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none appearance-none cursor-pointer">
                                <option value="Pendiente" {{ $prestamo->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Aceptado" {{ $prestamo->estado == 'Aceptado' ? 'selected' : '' }}>Aceptado (Para entrega)</option>
                                <option value="Activo" {{ $prestamo->estado == 'Activo' ? 'selected' : '' }}>Activo (En préstamo)</option>
                                <option value="Devuelto" {{ $prestamo->estado == 'Devuelto' ? 'selected' : '' }}>Devuelto (Completado)</option>
                                <option value="Rechazado" {{ $prestamo->estado == 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                    </div>

                    {{-- Fecha Límite --}}
                    <div class="space-y-1.5">
                        <label for="fecha_devolucion_esperada" class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-600 dark:text-slate-400 ml-1">Límite de Devolución</label>
                        <div class="relative group/input">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-600 group-focus-within/input:text-[#39A900] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <input type="datetime-local" id="fecha_devolucion_esperada" name="fecha_devolucion_esperada" 
                                   value="{{ $prestamo->fecha_devolucion_esperada ? $prestamo->fecha_devolucion_esperada->format('Y-m-d\TH:i') : '' }}"
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-800 dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none">
                        </div>
                    </div>

                    {{-- Fecha Devolución Real --}}
                    <div class="space-y-1.5">
                        <label for="fecha_devolucion_real" class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-600 dark:text-slate-400 ml-1">Fecha de Devolución Real</label>
                        <div class="relative group/input">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-600 group-focus-within/input:text-[#39A900] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="datetime-local" id="fecha_devolucion_real" name="fecha_devolucion_real" 
                                   value="{{ $prestamo->fecha_devolucion_real ? \Carbon\Carbon::parse($prestamo->fecha_devolucion_real)->format('Y-m-d\TH:i') : '' }}"
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-800 dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none">
                        </div>
                    </div>
                </div>

                {{-- Observaciones --}}
                <div class="mt-6 space-y-1.5">
                    <label for="observaciones" class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-600 dark:text-slate-400 ml-1">Observaciones / Notas de Auditoría</label>
                    <textarea id="observaciones" name="observaciones" rows="4" 
                              placeholder="Escribe detalles sobre la entrega, estado del equipo o motivos de rechazo..."
                              class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-800 dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none placeholder:text-slate-300 dark:placeholder:text-slate-600 resize-none leading-relaxed">{{ $prestamo->observaciones }}</textarea>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.prestamos.index') }}" 
                       class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        Descartar
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-[#39A900] text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-green-700 transition-all shadow-lg shadow-green-100 dark:shadow-none active:scale-95 flex items-center gap-2 border border-transparent dark:border-slate-700">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Actualizar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
