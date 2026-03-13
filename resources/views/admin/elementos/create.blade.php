<x-admin-layout>
    <div class="mb-2 flex items-center justify-between">
        <div>
            <h2 class="font-black text-xl text-[#00324D] dark:text-white leading-tight tracking-tight">
                {{ __('Registrar') }} <span class="text-[#39A900]">Nuevo Elemento</span>
            </h2>
            <p class="text-black dark:text-slate-400 text-[10px] font-black uppercase tracking-widest mt-0.5">
                Inventario técnico <span class="text-[#39A900] ml-1 font-black">SENA</span>
            </p>
        </div>
        <a href="{{ route('admin.elementos.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-[#00324D] dark:hover:text-white transition-colors font-bold text-[10px] uppercase tracking-widest bg-white dark:bg-slate-900 px-3 py-1.5 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Volver
        </a>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-slate-900 rounded-[1.5rem] shadow-[0_15px_40px_-12px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-slate-800 overflow-hidden relative group">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#39A900] to-[#00324D]"></div>
            
            <form action="{{ route('admin.elementos.store') }}" method="POST" enctype="multipart/form-data" class="p-5 md:p-6 text-black">
                @csrf
                
                @if ($errors->any())
                    <div class="p-4 mb-4 bg-rose-50 dark:bg-rose-900/20 border-l-4 border-rose-500 rounded-xl animate-fade-in">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <h3 class="text-xs font-black uppercase tracking-widest text-rose-600 dark:text-rose-400">Hay errores en el formulario</h3>
                        </div>
                        <ul class="list-disc list-inside text-[10px] font-bold text-rose-500 dark:text-rose-400 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Nombre --}}
                    <div class="space-y-1">
                        <label for="nombre" class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 ml-1">Nombre del Elemento</label>
                        <div class="relative">
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej: Lenovo ThinkPad P15"
                                   class="w-full pl-4 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border @error('nombre') border-rose-500 @else border-slate-100 dark:border-slate-700 @enderror rounded-xl text-sm font-bold text-[#00324D] dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none placeholder:text-slate-300 dark:placeholder:text-slate-600">
                            @error('nombre')
                                <p class="text-[9px] text-rose-500 font-bold mt-1 ml-1 capitalize">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Código SENA --}}
                    <div class="space-y-1">
                        <label for="codigo_sena" class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 ml-1">Código SENA / Placa</label>
                        <input type="text" id="codigo_sena" name="codigo_sena" value="{{ old('codigo_sena') }}" required placeholder="ID Único"
                               class="w-full pl-4 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border @error('codigo_sena') border-rose-500 @else border-slate-100 dark:border-slate-700 @enderror rounded-xl text-sm font-mono font-bold text-[#39A900] focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none">
                        @error('codigo_sena')
                            <p class="text-[9px] text-rose-500 font-bold mt-1 ml-1 capitalize">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Categoría --}}
                    <div class="space-y-1">
                        <label for="categoria_id" class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 ml-1">Categoría</label>
                        <select name="categoria_id" id="categoria_id" required
                                class="w-full px-4 pr-10 py-2.5 bg-slate-50 dark:bg-slate-800 border @error('categoria_id') border-rose-500 @else border-slate-100 dark:border-slate-700 @enderror rounded-xl text-sm font-bold text-[#00324D] dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none appearance-none cursor-pointer">
                            <option value="" disabled selected>Seleccionar categoría...</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <p class="text-[9px] text-rose-500 font-bold mt-1 ml-1 capitalize">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="space-y-1">
                        <label for="estado" class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 ml-1">Estado Inicial</label>
                        <select name="estado" id="estado" required
                                class="w-full px-4 pr-10 py-2.5 bg-slate-50 dark:bg-slate-800 border @error('estado') border-rose-500 @else border-slate-100 dark:border-slate-700 @enderror rounded-xl text-sm font-bold text-[#00324D] dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none appearance-none cursor-pointer">
                            <option value="Disponible" {{ old('estado') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="En Mantenimiento" {{ old('estado') == 'En Mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                            <option value="Dado de Baja" {{ old('estado') == 'Dado de Baja' ? 'selected' : '' }}>Dado de Baja</option>
                        </select>
                        @error('estado')
                            <p class="text-[9px] text-rose-500 font-bold mt-1 ml-1 capitalize">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Imagen --}}
                    <div class="md:col-span-2 space-y-1">
                        <label for="imagen" class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 ml-1">Imagen del Equipo</label>
                        <div class="flex items-center gap-4">
                            <div id="image-preview" class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden">
                                <svg class="w-8 h-8 text-slate-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="flex-1">
                                <input type="file" id="imagen" name="imagen" accept="image/*"
                                       onchange="previewImage(this)"
                                       class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-[#00324D] file:text-white hover:file:bg-black transition-all cursor-pointer">
                                <p class="text-[9px] text-slate-400 mt-1 font-bold">PNG, JPG o WEBP (Máx. 100MB)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function previewImage(input) {
                        const preview = document.getElementById('image-preview');
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain">`;
                                preview.classList.remove('border-dashed');
                                preview.classList.add('border-solid', 'border-[#39A900]/20');
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>

                {{-- Descripción --}}
                <div class="mt-4 space-y-1">
                    <label for="descripcion" class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 ml-1">Descripción Técnica</label>
                    <textarea id="descripcion" name="descripcion" rows="3" placeholder="Detalles técnicos..."
                              class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl text-sm font-medium text-[#00324D] dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none resize-none placeholder:text-slate-300 dark:placeholder:text-slate-600">{{ old('descripcion') }}</textarea>
                </div>

                {{-- Acciones --}}
                <div class="mt-6 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.elementos.index') }}" 
                       class="px-5 py-2 text-[10px] font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 hover:text-[#00324D] dark:hover:text-white transition-colors bg-slate-50 dark:bg-slate-800 rounded-xl">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-[#39A900] hover:bg-[#2d8500] text-white font-black text-[10px] uppercase tracking-[0.15em] rounded-xl shadow-lg shadow-[#39A900]/20 transition-all active:scale-95 group flex items-center gap-2">
                        <span>Guardar Elemento</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
