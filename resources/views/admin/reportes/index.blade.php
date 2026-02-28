<x-admin-layout>
    <div class="mb-8">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Centro de Reportes y Estadísticas') }}
        </h2>
    </div>

    <div>
        <div class="max-w-7xl mx-auto">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-indigo-500 text-center">
                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-2">Tasa de Uso</h4>
                    <p class="text-4xl font-black text-indigo-600">{{ $usoPorcentaje }}%</p>
                    <p class="text-xs text-gray-400 mt-2 italic">Equipos fuera de bodega hoy</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-green-500">
                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-2 text-center">Top Equipo</h4>
                    <div class="flex items-center justify-center gap-3">
                        <div class="text-center">
                            <p class="text-lg font-bold text-gray-800">{{ $topElemento->nombre ?? 'N/A' }}</p>
                            <p class="text-xs text-green-600 font-bold">{{ $topElemento->prestamos_count ?? 0 }} préstamos totales</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-yellow-500 text-center">
                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-2">Morosidad</h4>
                    <p class="text-4xl font-black text-yellow-600">{{ $totalVencidos }}</p>
                    <p class="text-xs text-gray-400 mt-2 italic">Préstamos retrasados actualmente</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-gray-700 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/></svg>
                        Equipos en Mantenimiento o Baja
                    </h3>
                    <ul class="divide-y divide-gray-100">
                        @forelse($equiposFuera as $equipo)
                        <li class="py-3 flex justify-between">
                            <span class="text-sm text-gray-700">{{ $equipo->nombre }} ({{ $equipo->codigo_sena }})</span>
                            <span class="text-xs font-bold {{ $equipo->estado == 'Dado de Baja' ? 'text-red-600' : 'text-yellow-600' }}">
                                {{ $equipo->estado }}
                            </span>
                        </li>
                        @empty
                        <li class="py-3 text-sm text-gray-400 italic text-center">Todo el inventario está operativo.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-indigo-900 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                    <h3 class="font-bold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Descargar Reportes Oficiales
                    </h3>
                    <p class="text-indigo-200 text-sm mb-6">Genere documentos listos para impresión para el control administrativo del SENA.</p>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.reportes.pdf', ['tipo' => 'inventario']) }}" class="flex items-center justify-between p-3 bg-indigo-800 rounded-lg hover:bg-indigo-700 transition">
                            <span class="text-sm">Inventario Completo (PDF)</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/></svg>
                        </a>
                        <a href="{{ route('admin.reportes.pdf', ['tipo' => 'prestamos_mes']) }}" class="flex items-center justify-between p-3 bg-indigo-800 rounded-lg hover:bg-indigo-700 transition">
                            <span class="text-sm">Préstamos del Mes (PDF)</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>