<x-admin-layout>
    <div class="mb-8">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Detalle del Movimiento') }} #{{ $movimiento->id }}
        </h2>
    </div>

    <div>
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Tipo de Movimiento</span>
                            <h3 class="text-2xl font-black text-gray-900">{{ $movimiento->tipo_movimiento }}</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-gray-400 uppercase">Fecha de Registro</span>
                            <p class="text-sm font-mono text-gray-600">{{ $movimiento->created_at->format('d/m/Y h:i:A') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 border-t border-b border-gray-100 py-6">
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 mb-2">Equipo Involucrado</h4>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm font-bold text-indigo-700">{{ $movimiento->elemento->nombre }}</p>
                                <p class="text-xs text-gray-500 font-mono italic">Placa: {{ $movimiento->elemento->codigo_sena }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-gray-800 mb-2">Responsable de la Acción</h4>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm font-bold text-gray-700">{{ $movimiento->user->name }}</p>
                                <p class="text-xs text-gray-500 italic">Rol: {{ $movimiento->user->getRoleNames()->first() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-sm font-bold text-gray-800 mb-2">Descripción / Observaciones</h4>
                        <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 text-gray-700 italic text-sm leading-relaxed">
                            {{ $movimiento->descripcion }}
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <a href="{{ route('admin.movimientos.index') }}" class="text-indigo-600 font-bold hover:underline">
                            ← Volver al Historial Completo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>