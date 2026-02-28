<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estado de mi Cuenta y Sanciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl p-8 border-t-8 {{ Auth::user()->sancionado ? 'border-red-600' : 'border-green-500' }}">
                
                <div class="text-center mb-10">
                    <h3 class="text-2xl font-black text-gray-800 uppercase italic">Estado Actual</h3>
                    @if(Auth::user()->sancionado)
                        <div class="mt-4">
                            <span class="px-6 py-2 bg-red-600 text-white rounded-full font-black animate-pulse">SOLICITUDES BLOQUEADAS</span>
                            <p class="mt-4 text-sm text-red-600 font-bold italic">No puedes realizar solicitudes en el catálogo hasta que expire tu sanción activa.</p>
                        </div>
                    @else
                        <div class="mt-4">
                            <span class="px-6 py-2 bg-green-500 text-white rounded-full font-black uppercase tracking-widest text-xs">Usuario al Día</span>
                            <p class="mt-4 text-sm text-gray-500 italic">Tu cuenta está habilitada para solicitar equipos en el Sistema de Préstamos SENA.</p>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest border-b pb-2">Registro de Sanciones</h4>
                    
                    @forelse($sanciones as $s)
                        <div class="p-6 rounded-2xl {{ $s->fecha_fin >= now() ? 'bg-red-50 border border-red-100' : 'bg-gray-50 border border-gray-100' }}">
                            <div class="flex justify-between items-start mb-4">
                                <span class="text-[10px] font-black uppercase {{ $s->fecha_fin >= now() ? 'text-red-600' : 'text-gray-400' }}">
                                    {{ $s->fecha_fin >= now() ? 'Sanción Vigente' : 'Sanción Cumplida' }}
                                </span>
                                <span class="text-xs font-mono text-gray-500 italic">{{ $s->created_at->format('d/m/Y') }}</span>
                            </div>
                            <p class="text-gray-700 text-sm leading-relaxed mb-4">
                                <strong>Motivo registrado:</strong> {{ $s->motivo }}
                            </p>
                            <div class="flex justify-between items-end border-t border-gray-200 pt-4">
                                <div class="text-xs text-gray-400">
                                    Inició: {{ $s->fecha_inicio->format('d/m/Y') }}
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Finaliza el:</p>
                                    <p class="text-sm font-black {{ $s->fecha_fin >= now() ? 'text-red-600' : 'text-gray-600' }}">{{ $s->fecha_fin->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <svg class="w-16 h-16 text-green-200 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <p class="text-gray-400 italic">No tienes antecedentes disciplinarios. ¡Sigue así!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>