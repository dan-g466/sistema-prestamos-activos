<x-admin-layout>
    <div class="mb-8">
        <h2 class="font-semibold text-2xl text-red-600 leading-tight">
            {{ __('Aplicar Nueva Sanción') }}
        </h2>
    </div>

    <div>
        <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 border-t-4 border-red-600">
                <form action="{{ route('admin.sanciones.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="user_id" :value="__('Usuario Sena a Sancionar')" />
                            <select name="user_id" id="user_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 mt-1" required>
                                <option value="">Seleccione un usuario...</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->documento }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="motivo" :value="__('Motivo detallado')" />
                            <textarea id="motivo" name="motivo" class="w-full border-gray-300 rounded-md shadow-sm mt-1" rows="3" required placeholder="Ej: No entregó el portátil en la fecha acordada..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="fecha_inicio" :value="__('Fecha de Inicio')" />
                                <x-text-input id="fecha_inicio" type="date" name="fecha_inicio" class="w-full mt-1" required value="{{ date('Y-m-d') }}" />
                            </div>
                            <div>
                                <x-input-label for="fecha_fin" :value="__('Fecha de Expiración')" />
                                <x-text-input id="fecha_fin" type="date" name="fecha_fin" class="w-full mt-1" required />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 gap-4 italic text-sm">
                        <a href="{{ route('admin.sanciones.index') }}" class="text-gray-600 pt-2 hover:underline">Cancelar</a>
                        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-red-700 transition">
                            Confirmar Bloqueo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>