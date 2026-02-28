<x-admin-layout>
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white rounded-2xl shadow-sm border border-slate-100 hidden sm:block">
                <svg class="w-6 h-6 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-[#00324D] leading-tight tracking-tight">
                    {{ __('Editar') }} <span class="text-[#39A900]">Categoría</span>
                </h2>
                <p class="text-slate-600 text-[10px] uppercase font-black tracking-widest mt-1 italic">
                    {{ $categoria->nombre }} <span class="mx-2 text-slate-300">|</span> 
                    Ref: <span class="text-[#39A900] font-black uppercase">CAT-{{ sprintf('%03d', $categoria->id) }}</span>
                </p>
            </div>
        </div>
        <a href="{{ route('admin.categorias.index') }}" 
           class="flex items-center gap-2 text-slate-400 hover:text-[#00324D] transition-all group px-4 py-2 bg-white rounded-xl border border-slate-50 shadow-sm active:scale-95">
            <div class="p-1.5 rounded-lg bg-slate-50 group-hover:bg-slate-100 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest">Volver al listado</span>
        </a>
    </div>

    <div class="max-w-4xl">
        <div class="bg-white rounded-[2.5rem] shadow-[0_25px_60px_-15px_rgba(0,0,0,0.08)] border border-slate-100 overflow-hidden relative group">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#39A900] to-[#00324D]"></div>
            
            <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST" class="p-6 md:p-8 text-black">
                @csrf @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    {{-- Nombre Section --}}
                    <div class="md:col-span-12 space-y-2">
                        <label for="nombre" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-black ml-1">
                            <svg class="w-3 h-3 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                            Nombre Identificador
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-[#39A900]">
                                <svg class="w-4 h-4 text-slate-300 group-focus-within:text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required placeholder="Ej: Maquinaria Pesada o Equipos de Cómputo"
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-[13px] font-bold text-[#00324D] focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none">
                        </div>
                        @error('nombre') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider flex items-center gap-1"><span class="w-1 h-1 bg-current rounded-full"></span> {{ $message }}</p> @enderror
                    </div>

                    {{-- Descripción Section --}}
                    <div class="md:col-span-12 space-y-2">
                        <label for="descripcion" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-black ml-1">
                            <svg class="w-3 h-3 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m7 6H7"/></svg>
                            Descripción y Alcance
                        </label>
                        <div class="relative group">
                            <textarea id="descripcion" name="descripcion" rows="4" placeholder="Define qué tipo de elementos pertenecen a esta categoría para facilitar su clasificación..."
                                      class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-[13px] font-medium text-[#00324D] focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none resize-none leading-relaxed">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                        </div>
                        @error('descripcion') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider flex items-center gap-1"><span class="w-1 h-1 bg-current rounded-full"></span> {{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row shadow-inner items-center justify-between gap-4">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest hidden sm:block italic">Última actualización: {{ $categoria->updated_at->diffForHumans() }}</p>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <a href="{{ route('admin.categorias.index') }}" 
                           class="flex-1 sm:flex-none text-center px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-colors bg-slate-50 sm:bg-transparent rounded-xl">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="flex-1 sm:flex-none px-10 py-3.5 bg-gradient-to-r from-[#00324D] to-[#002538] text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:scale-[1.02] hover:shadow-2xl hover:shadow-[#00324D]/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Actualizar Categoría
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
