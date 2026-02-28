<x-admin-layout>
    <div class="mb-8">
        <h2 class="font-semibold text-2xl text-red-600 leading-tight">
            {{ __('Restaurar Base de Datos') }}
        </h2>
    </div>

    <div>
        <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-red-100">
                <div class="p-8">
                    <div class="bg-red-50 p-4 rounded-lg mb-6 border-l-4 border-red-500">
                        <p class="text-sm text-red-700">
                            <strong>¡ADVERTENCIA CRÍTICA!</strong> Al cargar un archivo de backup, se borrarán todos los datos actuales (usuarios, préstamos, elementos) y se reemplazarán por los del archivo. Esta acción no se puede deshacer.
                        </p>
                    </div>

                    <form action="{{ route('admin.backups.restore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="backup_file" :value="__('Seleccione el archivo .sql o .gz')" />
                                <input type="file" name="backup_file" id="backup_file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-2" required />
                            </div>

                            <div class="bg-gray-50 p-4 rounded text-xs text-gray-600 italic">
                                Asegúrese de que el archivo sea una copia válida generada por este sistema.
                            </div>

                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.backups.index') }}" class="text-sm text-gray-600">Cancelar</a>
                                <x-primary-button class="bg-red-600 hover:bg-red-700 focus:bg-red-800 active:bg-red-900">
                                    {{ __('Iniciar Restauración') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>