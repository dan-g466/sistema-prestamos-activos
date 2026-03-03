<x-admin-layout>
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="font-black text-2xl text-[#00324D] leading-tight tracking-tight">
                Perfil de <span class="text-[#39A900]">{{ $user->name }}</span>
            </h2>
            <p class="text-slate-600 text-[10px] uppercase font-black tracking-widest mt-1">
                Historial de {{ $user->hasRole('Lider Admin') ? 'Administrador' : 'Aprendiz' }} <span class="mx-2 text-slate-300">|</span> Doc: {{ $user->documento }}
            </p>
        </div>
        <a href="{{ route('admin.usuarios.index') }}"
           class="flex items-center gap-2 text-slate-400 hover:text-[#00324D] transition-colors group">
            <div class="p-2 rounded-xl bg-slate-50 group-hover:bg-slate-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest hidden md:block">Volver</span>
        </a>
    </div>

    <div class="max-w-5xl space-y-5">
        {{-- Tarjeta de Información General --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#39A900] to-[#00324D]"></div>
            <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#39A900] to-green-600 flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-green-600/20 flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Correo</p>
                        <p class="font-bold text-[#00324D] text-sm mt-0.5">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Teléfono</p>
                        <p class="font-bold text-[#00324D] text-sm mt-0.5">{{ $user->telefono ?? 'No registrado' }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Registro</p>
                        <p class="font-bold text-[#00324D] text-sm mt-0.5">{{ optional($user->created_at)->format('d M, Y') ?? 'N/A' }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.usuarios.edit', ['user' => $user->id]) }}"
                   class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-[#00324D] text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#002538] transition-all shadow-lg shadow-[#00324D]/20 active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar
                </a>
            </div>
        </div>

        {{-- Historial de Préstamos --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                <div class="p-2 bg-slate-50 rounded-xl">
                    <svg class="w-4 h-4 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 class="text-[10px] font-black text-[#00324D] uppercase tracking-widest">Historial de Préstamos</h3>
                <span class="ml-auto text-[9px] font-black px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">{{ $user->prestamos->count() }} registros</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-500 uppercase tracking-widest">Equipo</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-500 uppercase tracking-widest">Solicitud</th>
                            <th class="px-6 py-2 text-left text-[8px] font-black text-slate-500 uppercase tracking-widest">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($user->prestamos as $prestamo)
                            <tr class="hover:bg-slate-50/50 transition-colors text-[11px]">
                                <td class="px-6 py-2 font-bold text-[#00324D]">{{ $prestamo->elemento->nombre }}</td>
                                <td class="px-6 py-2 text-slate-500">{{ optional($prestamo->fecha_solicitud)->format('d/m/Y') ?? '—' }}</td>
                                <td class="px-6 py-2">
                                    @php
                                        $colors = [
                                            'Pendiente' => 'bg-amber-100 text-amber-600 border-amber-200',
                                            'Activo'    => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                            'Devuelto'  => 'bg-slate-100 text-slate-400 border-slate-200',
                                            'Rechazado' => 'bg-rose-100 text-rose-600 border-rose-200',
                                        ];
                                        $color = $colors[$prestamo->estado] ?? 'bg-slate-100 text-slate-400 border-slate-200';
                                    @endphp
                                    <span class="inline-flex px-2 py-0.5 text-[8px] font-black uppercase tracking-widest rounded-full border {{ $color }}">
                                        {{ $prestamo->estado }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-400 font-bold text-xs uppercase tracking-widest">Sin préstamos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sanciones --}}
        @if($user->sanciones->count() > 0)
        <div class="bg-white rounded-[2rem] shadow-sm border border-rose-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-rose-50 flex items-center gap-3">
                <div class="p-2 bg-rose-50 rounded-xl">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-[10px] font-black text-rose-700 uppercase tracking-widest">Sanciones Registradas</h3>
                <span class="ml-auto text-[9px] font-black px-2 py-0.5 bg-rose-100 text-rose-600 rounded-full">{{ $user->sanciones->count() }}</span>
            </div>
            <div class="divide-y divide-rose-50">
                @foreach($user->sanciones as $sancion)
                    <div class="px-6 py-3 flex items-center gap-4 text-[11px]">
                        <div class="flex-1">
                            <p class="font-bold text-[#00324D]">{{ $sancion->motivo ?? 'Devolución tardía' }}</p>
                            <p class="text-[9px] text-slate-400 mt-0.5">{{ optional($sancion->created_at)->format('d M, Y') ?? '—' }}</p>
                        </div>
                        <span class="text-[8px] font-black px-2 py-0.5 rounded-full bg-rose-100 text-rose-600 border border-rose-200 uppercase tracking-widest">{{ $sancion->estado ?? 'Activa' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>