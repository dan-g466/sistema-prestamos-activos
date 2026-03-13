<x-admin-layout>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="font-black text-2xl text-[#00324D] dark:text-white leading-tight tracking-tight">
                {{ __('Editar') }} <span class="text-[#39A900]">{{ $user->hasRole('Lider Admin') ? 'Administrador' : 'Usuario Sena' }}</span>
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-[10px] uppercase font-black tracking-widest mt-1">
                Gestión de Cuenta <span class="mx-2 text-slate-300 dark:text-slate-700">|</span> ID: {{ $user->documento }}
            </p>
        </div>
        <a href="{{ route('admin.usuarios.index') }}"
            class="flex items-center gap-2 text-slate-500 hover:text-[#00324D] dark:hover:text-white transition-colors group">
            <div class="p-2 rounded-xl bg-slate-50 dark:bg-slate-800 group-hover:bg-slate-100 dark:group-hover:bg-slate-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest hidden md:block">Volver</span>
        </a>
    </div>

    <div class="max-w-3xl">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-slate-800 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#39A900] to-[#00324D]"></div>

            {{-- Cabecera del Perfil --}}
            <div class="px-8 pt-8 pb-5 flex items-center gap-4 border-b border-slate-50 dark:border-slate-800">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#39A900] to-green-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-green-600/20">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <p class="font-black text-lg text-[#00324D] dark:text-white leading-tight">{{ $user->name }}</p>
                    <p class="text-[10px] font-black text-[#39A900] uppercase tracking-widest">{{ $user->hasRole('Lider Admin') ? 'Administrador' : 'Usuario Sena' }}</p>
                </div>
            </div>

            <form action="{{ route('admin.usuarios.update', ['user' => $user->id]) }}" method="POST" class="p-6 md:p-8 text-black dark:text-white">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Nombre --}}
                    <div class="md:col-span-2 space-y-1.5">
                        <label for="name" class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 ml-1">Nombre Completo</label>
                        <div class="relative group/input">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within/input:text-[#39A900] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-[#00324D] dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none">
                        </div>
                        @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1.5">
                        <label for="email" class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 ml-1">Correo Electrónico</label>
                        <div class="relative group/input">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within/input:text-[#39A900] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-[#00324D] dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none">
                        </div>
                        @error('email') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                    </div>

                    {{-- Documento --}}
                    <div class="space-y-1.5">
                        <label for="documento" class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 ml-1">Número de Documento</label>
                        <div class="relative group/input">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within/input:text-[#39A900] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
                            </div>
                            <input type="text" id="documento" name="documento" value="{{ old('documento', $user->documento) }}" required
                                   inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   title="Solo se aceptan caracteres numéricos"
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-mono font-bold text-[#00324D] dark:text-white focus:ring-4 focus:ring-[#39A900]/5 focus:border-[#39A900] transition-all outline-none font-mono">
                        </div>
                        @error('documento') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                    </div>

                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-50 dark:border-slate-800 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.usuarios.index') }}"
                       class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors bg-slate-50 dark:bg-slate-800 rounded-xl">
                        Descartar
                    </a>
                    <button type="submit"
                            class="px-8 py-3 bg-[#00324D] text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#002538] transition-all shadow-lg shadow-[#00324D]/20 active:scale-95 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
