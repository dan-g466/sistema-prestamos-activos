<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SENA - Portal Aprendiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Outfit', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        .bg-pattern {
            background-image: radial-gradient(#39A900 0.5px, transparent 0.5px);
            background-size: 24px 24px;
            opacity: 0.03;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
        }
    </style>
</head>

<body class="bg-[#fcfdf2] text-slate-900 antialiased overflow-hidden" x-data="{ sidebarOpen: window.innerWidth >= 1024 }" @resize.window="sidebarOpen = window.innerWidth >= 1024">
    {{-- Textura de Fondo --}}
    <div class="fixed inset-0 bg-pattern pointer-events-none"></div>

    <div class="flex h-screen relative z-10">

        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen && window.innerWidth < 1024" x-cloak @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-md lg:hidden transition-opacity"></div>

        {{-- Sidebar SENA Premium --}}
        <aside class="bg-[#39A900] w-64 flex-shrink-0 flex flex-col fixed inset-y-0 z-50 transition-all duration-500 shadow-[0_0_50px_-15px_rgba(57,169,0,0.3)]"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Branding Section con Brillo -->
            <div class="p-8 pb-4 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10 flex flex-col items-center gap-5 translate-y-0 group-hover:-translate-y-1 transition-transform duration-500">
                    <div class="group-hover:rotate-[5deg] transition-all duration-500">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo SENA" class="h-16 w-auto object-contain brightness-0 invert">
                    </div>
                    <div class="text-center">
                        <span class="block text-white font-black text-[10px] uppercase tracking-[0.5em] leading-tight mb-1 opacity-90">Portal <span class="text-white/60">Aprendiz</span></span>
                        <div class="h-1 w-10 bg-white/40 mx-auto rounded-full group-hover:w-16 group-hover:bg-white transition-all duration-500"></div>
                    </div>
                </div>
            </div>

            <!-- Navigation Links Refinados -->
            <nav class="flex-1 mt-8 px-4 space-y-2 overflow-y-auto custom-scrollbar">
                <a href="{{ route('user.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[13px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('user.dashboard') ? 'bg-white text-[#39A900] shadow-[0_10px_20px_-5px_rgba(255,255,255,0.3)]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Escritorio</span>
                </a>

                <a href="{{ route('user.catalogo') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[13px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('user.catalogo') ? 'bg-white text-[#39A900] shadow-xl' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Catálogo</span>
                </a>

                <a href="{{ route('user.prestamos.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[13px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('user.prestamos.index') ? 'bg-white text-amber-600 shadow-[0_10px_20px_-5px_rgba(255,191,0,0.3)]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Mis Solicitudes</span>
                </a>

                <a href="{{ route('user.prestamos.activos') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[13px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('user.prestamos.activos') ? 'bg-white text-[#39A900] shadow-[0_10px_20px_-5px_rgba(255,255,255,0.3)]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    <span>Préstamos Activos</span>
                </a>

                <a href="{{ route('user.historial') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[13px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('user.historial') ? 'bg-white text-[#39A900] shadow-[0_10px_20px_-5px_rgba(255,255,255,0.3)]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:rotate-[-10deg] transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Mi Historial</span>
                </a>

                <div class="pt-6 pb-2 px-4">
                    <span class="text-[9px] font-black text-white/40 uppercase tracking-[0.3em]">Gestión</span>
                </div>

                <a href="{{ route('user.sanciones.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-[13px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('user.sanciones.*') ? 'bg-white text-rose-600 shadow-xl' : 'text-white/80 hover:bg-white/10 hover:text-white hover:bg-rose-500/10' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Sanciones</span>
                </a>
            </nav>

            <!-- Logout Estilizado -->
            <div class="mt-auto p-4 border-t border-white/10 bg-black/5 backdrop-blur-sm">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-4 rounded-2xl text-[11px] font-black text-white hover:bg-white group transition-all hover:text-[#39A900] active:scale-95 uppercase tracking-widest border border-white/20 shadow-lg">
                        <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Finalizar Sesión
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main View Area con Transiciones Suaves --}}
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-500" :class="sidebarOpen && window.innerWidth >= 1024 ? 'lg:ml-64' : ''">
            
            {{-- Global Header Glassmorphism --}}
            <header class="h-20 glass-header sticky top-0 z-30 flex items-center justify-between px-8 border-b border-white/40 shadow-sm">
                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = !sidebarOpen" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-[#39A900] hover:shadow-lg transition-all flex items-center justify-center active:scale-90">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="hidden sm:block">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5 opacity-60">Centro Ind. del Diseño</p>
                        <h1 class="text-sm font-black text-[#00324D] uppercase tracking-tight">Reg. Formación Profesional</h1>
                    </div>
                </div>

                <div class="flex items-center gap-5">
                    <div class="flex items-center gap-4 pl-6 border-l border-slate-100">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-black text-[#00324D] leading-none mb-1">{{ Auth::user()->name }}</p>
                            <span class="text-[9px] font-black text-[#39A900] uppercase tracking-widest">Activo • Aprendiz</span>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-tr from-[#39A900] to-[#00324D] rounded-2xl flex items-center justify-center text-white text-xl font-black shadow-xl shadow-green-900/10 border-2 border-white ring-4 ring-slate-50">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="flex-1 overflow-y-auto p-6 md:p-10 relative custom-scrollbar">
                @if(session('success'))
                    <div class="max-w-4xl mx-auto mb-8 bg-white/60 backdrop-blur-md border-l-8 border-[#39A900] p-5 rounded-[1.8rem] shadow-xl shadow-green-900/5 animate-in slide-in-from-top-4 duration-500 overflow-hidden relative">
                        <div class="absolute right-0 top-0 w-24 h-full bg-gradient-to-l from-green-50 to-transparent"></div>
                        <div class="relative z-10 flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#39A900] rounded-xl flex items-center justify-center text-white shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-800 tracking-tight">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
