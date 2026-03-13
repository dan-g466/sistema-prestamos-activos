<x-admin-layout>
    <div class="mb-10">
        <h2 class="font-black text-3xl text-slate-800 dark:text-white leading-tight tracking-tight">
            {{ __('Seguridad') }} <span class="text-[#39A900]">SENA</span>
        </h2>
        <p class="text-slate-500 dark:text-slate-400 text-[10px] uppercase font-black tracking-widest mt-1">Gestión de Copias de Seguridad y Restauración</p>
    </div>
    <div>
        <div class="max-w-7xl mx-auto">
            
            <div class="flex items-center gap-4 mb-10">
                <a href="{{ route('admin.backups.create') }}" class="bg-[#39A900] hover:bg-[#2d8500] text-white text-[10px] font-black uppercase tracking-widest py-4 px-10 rounded-2xl shadow-xl shadow-green-900/20 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 whitespace-nowrap flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Backup
                </a>
                <a href="{{ route('admin.backups.upload') }}" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 hover:border-[#39A900] hover:text-[#39A900] text-[10px] font-black uppercase tracking-widest py-4 px-8 rounded-2xl shadow-sm transition-all duration-300 flex items-center gap-2 group whitespace-nowrap active:scale-95">
                    <svg class="w-4 h-4 group-hover:translate-y-[-2px] transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Restaurar
                </a>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                        <thead class="bg-slate-50/50 dark:bg-slate-800/20">
                            <tr>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Archivo</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Tamaño</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Fecha</th>
                                <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($backups as $backup)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="px-8 py-5 whitespace-nowrap font-mono text-[11px] text-[#39A900] font-black uppercase tracking-tight">{{ $backup['file_name'] }}</td>
                                <td class="px-8 py-5 whitespace-nowrap text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">{{ $backup['file_size'] }}</td>
                                <td class="px-8 py-5 whitespace-nowrap text-[11px] font-black text-slate-400 dark:text-slate-600 uppercase">{{ $backup['last_modified'] }}</td>
                                <td class="px-8 py-5 whitespace-nowrap text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.backups.download', $backup['file_name']) }}" 
                                           class="p-2.5 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:text-[#39A900] dark:hover:text-[#39A900] rounded-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 hover:border-[#39A900] dark:hover:border-[#39A900] active:scale-90"
                                           title="Descargar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('admin.backups.destroy', $backup['file_name']) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2.5 bg-rose-50 dark:bg-rose-900/10 text-rose-400 hover:text-rose-600 dark:hover:text-rose-400 rounded-xl transition-all duration-300 border border-rose-100 dark:border-rose-900/30 hover:border-rose-500 dark:hover:border-rose-500 active:scale-90" 
                                                    onclick="return confirm('¿Seguro que quieres eliminar este archivo?')"
                                                    title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                             @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="text-slate-400 dark:text-slate-600 text-[10px] font-black uppercase tracking-[0.2em] italic">No hay copias de seguridad disponibles</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

