<x-admin-layout>
    <div class="mb-10">
        <h2 class="font-black text-3xl text-gray-800 leading-tight tracking-tight">
            {{ __('Seguridad') }} <span class="text-[#39A900]">SENA</span>
        </h2>
    </div>

    <div>
        <div class="max-w-7xl mx-auto">
            
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('admin.backups.create') }}" class="bg-[#39A900] hover:bg-[#2d8500] text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-green-900/10 transition-all duration-300 transform hover:-translate-y-0.5 whitespace-nowrap">
                    + Nuevo Backup
                </a>
                <a href="{{ route('admin.backups.upload') }}" class="bg-white border-2 border-gray-200 text-gray-500 hover:border-[#39A900] hover:text-[#39A900] font-bold py-2.5 px-6 rounded-2xl shadow-sm transition-all duration-300 flex items-center gap-2 group whitespace-nowrap">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Restaurar
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-0 text-gray-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Archivo</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tamaño</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Fecha</th>
                                <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($backups as $backup)
                            <tr>
                                <td class="px-8 py-5 whitespace-nowrap font-mono text-sm text-[#39A900] font-bold">{{ $backup['file_name'] }}</td>
                                <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500">{{ $backup['file_size'] }}</td>
                                <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-400">{{ $backup['last_modified'] }}</td>
                                <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.backups.download', $backup['file_name']) }}" 
                                           class="p-2 text-gray-400 hover:text-[#39A900] hover:bg-[#39A900]/5 rounded-xl transition-all duration-300 group"
                                           title="Descargar">
                                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('admin.backups.destroy', $backup['file_name']) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-300 group" 
                                                    onclick="return confirm('¿Seguro que quieres eliminar este archivo?')"
                                                    title="Eliminar">
                                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center text-gray-400 italic text-sm">
                                    No hay copias de seguridad disponibles.
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

