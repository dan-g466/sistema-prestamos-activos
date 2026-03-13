<x-admin-layout>
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 hidden sm:block">
                <svg class="w-6 h-6 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <h2 class="font-black text-2xl text-[#00324D] dark:text-white leading-tight tracking-tight">
                    {{ __('Usuarios') }} <span class="text-[#39A900]">SENA</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-[10px] uppercase font-black tracking-widest mt-1 italic">
                    Gestión de Usuarios Registrados <span class="mx-2 text-slate-300 dark:text-slate-700">|</span> <span class="text-[#39A900]">Admin</span>
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto pb-8">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                    <thead class="bg-slate-50/50 dark:bg-slate-800/50 uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-600 dark:text-slate-400">Usuario / Identidad</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-600 dark:text-slate-400">Correo Electrónico</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-600 dark:text-slate-400">Documento</th>
                            <th class="px-8 py-2 text-right text-[8px] font-black text-slate-600 dark:text-slate-400">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($usuarios as $usuario)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group/row text-[11px]">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#39A900] to-green-600 flex items-center justify-center text-white font-black text-[10px] uppercase shadow-sm">
                                            {{ strtoupper(substr($usuario->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-[#00324D] dark:text-white uppercase group-hover/row:text-[#39A900] transition-colors leading-tight">
                                                {{ $usuario->name }}
                                            </div>
                                            <div class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-wider">
                                                {{ $usuario->hasRole('Lider Admin') ? 'Administrador' : 'Usuario Sena' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">
                                    <div class="font-bold text-[#00324D] dark:text-slate-300">{{ $usuario->email }}</div>
                                </td>
                                <td class="px-6 py-2">
                                    <span class="text-[9px] font-mono font-black text-[#39A900] bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded-lg border border-green-100 dark:border-green-900/30">
                                        {{ $usuario->documento }}
                                    </span>
                                </td>
                                <td class="px-8 py-2 text-right">
                                    <div class="flex justify-end items-center gap-1.5">
                                        {{-- Ver Perfil --}}
                                        <a href="{{ route('admin.usuarios.show', ['user' => $usuario->id]) }}"
                                           class="p-1.5 bg-slate-50 dark:bg-slate-800 text-slate-500 hover:bg-[#39A900] dark:hover:bg-[#39A900] hover:text-white rounded-lg transition-all border border-slate-200 dark:border-slate-700 hover:border-[#39A900] shadow-sm active:scale-90"
                                           title="Ver Historial">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>

                                        {{-- Editar --}}
                                        <a href="{{ route('admin.usuarios.edit', ['user' => $usuario->id]) }}"
                                           class="p-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white rounded-lg transition-all border border-blue-100 dark:border-blue-900/30 hover:border-blue-600 shadow-sm active:scale-90"
                                           title="Editar">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>

                                        {{-- Eliminar --}}
                                        <form id="user-delete-{{ $usuario->id }}" action="{{ route('admin.usuarios.destroy', ['user' => $usuario->id]) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button"
                                                    onclick="confirmDelete('user-delete-{{ $usuario->id }}', 'Se eliminará al usuario {{ addslashes($usuario->name) }} y todos sus datos asociados.')"
                                                    class="p-1.5 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white rounded-lg transition-all border border-rose-100 dark:border-rose-900/30 hover:border-rose-600 shadow-sm active:scale-90"
                                                    title="Eliminar">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center">
                                    <div class="flex flex-col items-center gap-2 text-slate-200 dark:text-slate-800">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-widest leading-loose">No hay usuarios registrados.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($usuarios->hasPages())
                <div class="px-6 py-2 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20">
                    {{ $usuarios->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
