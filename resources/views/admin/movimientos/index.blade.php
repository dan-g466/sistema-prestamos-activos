<x-admin-layout>
    <div class="mb-8">
        <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight tracking-tight">
            {{ __('Historial de Movimientos') }} <span class="text-[#39A900]">Auditoría</span>
        </h2>
        <p class="text-slate-500 dark:text-slate-400 text-[10px] uppercase font-black tracking-widest mt-1">Registros de actividad en tiempo real</p>
    </div>

    <div>
        <div class="max-w-7xl mx-auto">
            
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm rounded-[2rem] border border-slate-100 dark:border-slate-800 transition-all">
                <div class="p-8 text-gray-900">
                    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold italic">
                            Mostrando los registros más recientes de actividad en el inventario.
                        </p>

                        <!-- Formulario de Filtros -->
                        <form action="{{ route('admin.movimientos.index') }}" method="GET" class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                            <!-- Filtro por Fecha -->
                            <input type="date" name="fecha" value="{{ request('fecha') }}" 
                                class="text-xs border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-[#39A900] focus:border-[#39A900] shadow-sm">
                            
                            <!-- Filtro por Tipo -->
                            <select name="tipo" class="text-xs border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:ring-[#39A900] focus:border-[#39A900] shadow-sm">
                                <option value="">Todos los tipos</option>
                                <option value="Aprobación" {{ request('tipo') == 'Aprobación' ? 'selected' : '' }}>Aprobación</option>
                                <option value="Entrega" {{ request('tipo') == 'Entrega' ? 'selected' : '' }}>Entrega</option>
                                <option value="Devolución Iniciada" {{ request('tipo') == 'Devolución Iniciada' ? 'selected' : '' }}>Devolución Iniciada</option>
                                <option value="Devolución Confirmada" {{ request('tipo') == 'Devolución Confirmada' ? 'selected' : '' }}>Devolución Confirmada</option>
                                <option value="Entrada" {{ request('tipo') == 'Entrada' ? 'selected' : '' }}>Entrada Manual</option>
                                <option value="Salida/Baja" {{ request('tipo') == 'Salida/Baja' ? 'selected' : '' }}>Salida/Baja</option>
                            </select>

                            <!-- Búsqueda por Texto -->
                            <div class="relative">
                                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar equipo o placa..." 
                                    class="text-xs border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg pl-8 focus:ring-[#39A900] focus:border-[#39A900] shadow-sm w-48">
                                <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>

                            <!-- Botones -->
                            <button type="submit" class="bg-[#39A900] hover:bg-[#2d8500] text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-[#39A900] dark:focus:ring-offset-slate-900">
                                Filtrar
                            </button>
                            
                            @if(request()->hasAny(['fecha', 'tipo', 'buscar']))
                                <a href="{{ route('admin.movimientos.index') }}" class="text-xs text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 font-bold underline decoration-slate-300 dark:decoration-slate-600 underline-offset-4 transition-colors">
                                    Limpiar
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                            <thead class="bg-slate-50 dark:bg-slate-800/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Fecha / Hora</th>
                                    <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Responsable</th>
                                    <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Tipo</th>
                                    <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Elemento</th>
                                    <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Descripción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse ($movimientos as $movimiento)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                                        <td class="px-6 py-4 whitespace-nowrap text-[10px] text-slate-500 dark:text-slate-400 font-bold font-mono">
                                            {{ $movimiento->created_at->format('d/m/Y') }}
                                            <span class="block text-[9px] text-slate-400 dark:text-slate-600">{{ $movimiento->created_at->format('h:i A') }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-[11px] font-black text-slate-900 dark:text-slate-200 uppercase tracking-tight">{{ $movimiento->user->name }}</div>
                                            <div class="text-[9px] text-[#39A900] font-black uppercase tracking-widest">{{ $movimiento->user->getRoleNames()->first() ?? 'Admin' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $color = match($movimiento->tipo_movimiento) {
                                                    'Entrada' => 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-400 border-green-200 dark:border-green-800/30',
                                                    'Entrega' => 'bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-400 border-blue-200 dark:border-blue-800/30',
                                                    'Devolución' => 'bg-indigo-100 dark:bg-indigo-900/20 text-indigo-800 dark:text-indigo-400 border-indigo-200 dark:border-indigo-800/30',
                                                    'Salida/Baja' => 'bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-400 border-red-200 dark:border-red-800/30',
                                                    'Cambio de Estado' => 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800/30',
                                                    default => 'bg-gray-100 dark:bg-slate-800 text-gray-800 dark:text-slate-400 border-gray-200 dark:border-slate-700'
                                                };
                                            @endphp
                                            <span class="px-2 py-0.5 text-[8px] font-black rounded-full uppercase tracking-widest border {{ $color }}">
                                                {{ $movimiento->tipo_movimiento }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-[11px] font-black text-slate-900 dark:text-slate-200 uppercase">{{ $movimiento->elemento->nombre }}</div>
                                            <div class="text-[9px] font-mono font-black text-slate-400 dark:text-slate-600 tracking-tighter">{{ $movimiento->elemento->codigo_sena }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-[10px] text-slate-600 dark:text-slate-400 font-medium">
                                            <span title="{{ $movimiento->descripcion }}" class="line-clamp-2 leading-relaxed">
                                                {{ $movimiento->descripcion }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="text-slate-400 dark:text-slate-600 italic text-xs font-bold">No se han registrado movimientos en el sistema aún.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 border-t border-slate-100 dark:border-slate-800/60 pt-6">
                        {{ $movimientos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>