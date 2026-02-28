<x-admin-layout>
    <div class="mb-8">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Historial de Movimientos y Auditoría') }}
        </h2>
    </div>

    <div>
        <div class="max-w-7xl mx-auto">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-800">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-4 flex justify-between items-center">
                        <p class="text-sm text-gray-600 italic">
                            Mostrando los registros más recientes de actividad en el inventario.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha / Hora</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Responsable</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Elemento</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Descripción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($movimientos as $movimiento)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                            {{ $movimiento->created_at->format('d/m/Y') }}
                                            <span class="block text-xs text-gray-400">{{ $movimiento->created_at->format('h:i A') }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">{{ $movimiento->user->name }}</div>
                                            <div class="text-xs text-gray-500 italic">{{ $movimiento->user->getRoleNames()->first() ?? 'Admin' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $color = match($movimiento->tipo_movimiento) {
                                                    'Entrada' => 'bg-green-100 text-green-800',
                                                    'Entrega' => 'bg-blue-100 text-blue-800',
                                                    'Devolución' => 'bg-indigo-100 text-indigo-800',
                                                    'Salida/Baja' => 'bg-red-100 text-red-800',
                                                    'Cambio de Estado' => 'bg-yellow-100 text-yellow-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="px-2 py-1 text-xs font-bold rounded-md {{ $color }}">
                                                {{ $movimiento->tipo_movimiento }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $movimiento->elemento->nombre }}</div>
                                            <div class="text-xs font-mono text-indigo-600">{{ $movimiento->elemento->codigo_sena }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <span title="{{ $movimiento->descripcion }}">
                                                {{ Str::limit($movimiento->descripcion, 50) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                                            No se han registrado movimientos en el sistema aún.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $movimientos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>