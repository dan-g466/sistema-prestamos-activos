<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema de Préstamos - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        sena: '#39A900',
                        'sena-dark': '#00324D',
                    }
                }
            }
        }
    </script>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] { display: none !important; }
        .swal2-popup { border-radius: 2rem !important; padding: 2rem !important; }
        .swal2-title { font-weight: 900 !important; color: #00324D !important; text-transform: uppercase !important; font-size: 1.25rem !important; letter-spacing: -0.025em !important; }
        .swal2-html-container { font-weight: 700 !important; color: #64748b !important; font-size: 0.875rem !important; }
        .swal2-confirm { background-color: #ef4444 !important; border-radius: 0.75rem !important; font-weight: 900 !important; text-transform: uppercase !important; font-size: 0.75rem !important; letter-spacing: 0.1em !important; padding: 0.8rem 2rem !important; }
        .swal2-cancel { background-color: #f1f5f9 !important; color: #94a3b8 !important; border-radius: 0.75rem !important; font-weight: 900 !important; text-transform: uppercase !important; font-size: 0.75rem !important; letter-spacing: 0.1em !important; padding: 0.8rem 2rem !important; }
        
        /* Dark mode overrides for scrollbar */
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
    </style>
    <script>
        window.confirmDelete = function(formId, title = '¿Confirmar Acción?', message = '¿Estás seguro de eliminar este registro?', isCascade = false, itemCount = 0) {
            let finalTitle = title;
            let finalMessage = message;
            let icon = 'warning';

            if (isCascade && itemCount > 0) {
                finalTitle = '¡Acción Crítica!';
                finalMessage = `Esta categoría tiene <b>${itemCount} elementos</b> vinculados. Al eliminarla, se borrarán permanentemente:<br><br>` +
                               `<ul class="text-left list-disc list-inside text-rose-600 font-bold space-y-1">` +
                               `<li>Todos sus elementos</li>` +
                               `<li>Historial de préstamos</li>` +
                               `<li>Movimientos de inventario</li>` +
                               `</ul><br>` +
                               `¿Estás absolutamente seguro? Esta acción no se puede deshacer.`;
                icon = 'error';
            }

            Swal.fire({
                title: finalTitle,
                html: finalMessage,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: isCascade && itemCount > 0 ? '#b91c1c' : '#ef4444',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'SÍ, ELIMINAR TODO',
                cancelButtonText: 'CANCELAR',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
</head>

<body class="bg-[#f8fafc] dark:bg-slate-950 font-sans antialiased selection:bg-green-100 selection:text-green-800" 
      x-data="{ 
        sidebarOpen: window.innerWidth >= 1024, 
        darkMode: localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
        themeTransitioning: false,
        toggleTheme() {
            this.themeTransitioning = true;
            setTimeout(() => {
                this.darkMode = !this.darkMode;
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            }, 300);
            setTimeout(() => { this.themeTransitioning = false; }, 800);
        }
      }" @resize.window="sidebarOpen = window.innerWidth >= 1024">

    {{-- Efecto de Transición de Tema Premium --}}
    <div x-show="themeTransitioning" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] bg-white dark:bg-slate-950 flex items-center justify-center transition-colors duration-300"
         x-cloak>
        <div class="relative">
            <img src="{{ asset('img/logo sena.png') }}" class="h-32 w-auto animate-pulse" alt="Cambiando Tema...">
            <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 whitespace-nowrap">
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-[#39A900] animate-bounce">Ajustando Estilo</p>
            </div>
        </div>
    </div>
    <div class="flex h-screen overflow-hidden bg-[#f8fafc] dark:bg-slate-950">

        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen && window.innerWidth < 1024"
             x-cloak
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        {{-- Sidebar Admin Premium - Green & White Distribution --}}
        <aside class="bg-[#39A900] dark:bg-slate-900 w-64 flex-shrink-0 flex flex-col fixed inset-y-0 z-50 transition-all duration-300 shadow-[10px_0_30px_-15px_rgba(0,0,0,0.2)] border-r border-white/10 dark:border-slate-800"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Branding Section -->
            <div class="p-6 pb-2">
                <div class="group flex flex-col items-center gap-4 transition-all duration-300">
                    <div class="group-hover:scale-105 transition-all duration-500 relative">
                        {{-- Logotipo adaptativo --}}
                        <img x-show="!darkMode" src="{{ asset('img/logo.png') }}" alt="Logo SENA" 
                             class="h-20 w-auto object-contain transition-all duration-500 brightness-0 invert">
                        <img x-show="darkMode" src="{{ asset('img/logo sena.png') }}" alt="Logo SENA" 
                             class="h-20 w-auto object-contain transition-all duration-500" x-cloak>
                    </div>
                    <div class="text-center">
                        <span class="block text-white font-black text-xs uppercase tracking-[0.4em] leading-tight">Admin <span class="text-white/70">Panel</span></span>
                        <div class="h-0.5 w-12 bg-white dark:bg-[#39A900] mx-auto mt-2 rounded-full transform group-hover:w-20 transition-all duration-500"></div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 mt-2 px-3 space-y-0.5 overflow-y-auto custom-scrollbar">
                <!-- Group: General -->
                <div class="pt-1 pb-0.5 px-3">
                    <span class="text-[9px] font-black text-white/60 uppercase tracking-[0.2em]">Principal</span>
                </div>
                
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#39A900] dark:bg-[#39A900] dark:text-white shadow-xl shadow-black/5 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Escritorio</span>
                </a>

                <!-- Group: Gestión -->
                <div class="pt-2 pb-0.5 px-3">
                    <span class="text-[9px] font-black text-white/60 uppercase tracking-[0.2em]">Gestión Física</span>
                </div>
                
                <a href="{{ route('admin.elementos.index') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('admin.elementos.*') ? 'bg-white text-[#39A900] dark:bg-[#39A900] dark:text-white shadow-xl shadow-black/5 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span>Elementos</span>
                </a>

                <a href="{{ route('admin.categorias.index') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('admin.categorias.*') ? 'bg-white text-[#39A900] dark:bg-[#39A900] dark:text-white shadow-xl shadow-black/5 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    <span>Categorías</span>
                </a>

                <!-- Group: Control -->
                <div class="pt-2 pb-0.5 px-3">
                    <span class="text-[9px] font-black text-white/60 uppercase tracking-[0.2em]">Operaciones</span>
                </div>

                <a href="{{ route('admin.prestamos.index') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('admin.prestamos.index') ? 'bg-[#00324D] dark:bg-slate-800 text-white shadow-xl shadow-black/10 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Préstamos</span>
                </a>

                <a href="{{ route('admin.prestamos.vencidos') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('admin.prestamos.vencidos') ? 'bg-white text-rose-600 dark:bg-rose-600 dark:text-white shadow-xl shadow-black/5 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Vencidos</span>
                </a>

                <a href="{{ route('admin.usuarios.index') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->is('admin/usuarios*') ? 'bg-white text-[#39A900] dark:bg-[#39A900] dark:text-white shadow-xl shadow-black/5 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Usuarios</span>
                </a>

                <a href="{{ route('admin.sanciones.index') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('admin.sanciones.*') ? 'bg-white text-rose-600 dark:bg-rose-600 dark:text-white shadow-xl shadow-black/5 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Sanciones</span>
                </a>

                <!-- Group: Sistema -->
                <div class="pt-2 pb-0.5 px-3">
                    <span class="text-[9px] font-black text-white/60 uppercase tracking-[0.2em]">Auditoría & Sis.</span>
                </div>

                <a href="{{ route('admin.reportes.index') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('admin.reportes.*') ? 'bg-white text-[#39A900] dark:bg-[#39A900] dark:text-white shadow-xl shadow-black/5 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Reportes</span>
                </a>

                <a href="{{ route('admin.movimientos.index') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('admin.movimientos.*') ? 'bg-white text-[#39A900] dark:bg-[#39A900] dark:text-white shadow-xl shadow-black/5 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16h6m-6-4h6m-6-4h6M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/></svg>
                    <span>Auditoría</span>
                </a>

                <a href="{{ route('admin.backups.index') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('admin.backups.*') ? 'bg-white text-[#39A900] dark:bg-[#39A900] dark:text-white shadow-xl shadow-black/5 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Backups</span>
                </a>

                <a href="{{ route('admin.elementos.import') }}"
                   class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-[12px] font-bold transition-all duration-300 group
                          {{ request()->routeIs('admin.elementos.import') ? 'bg-white text-[#39A900] dark:bg-[#39A900] dark:text-white shadow-xl shadow-black/5 scale-[1.02]' : 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-white/5 hover:text-white dark:hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <span>Cargar Excel</span>
                </a>
            </nav>

            <!-- Logout Button -->
            <div class="p-3 mt-auto border-t border-white/10 bg-black/5 dark:bg-slate-950/20">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-[11px] font-black text-white hover:bg-white/10 transition-all active:scale-95 uppercase tracking-widest border border-white/20">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main View Section --}}
        <div class="flex-1 flex flex-col overflow-hidden relative lg:ml-0" :class="sidebarOpen && window.innerWidth >= 1024 ? 'lg:ml-64' : ''">
            
            {{-- Header Balanced --}}
            <header class="h-14 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-30 flex items-center justify-between px-4 md:px-6 border-b border-slate-100 dark:border-slate-800 shadow-sm">
                <div class="flex items-center gap-3">
                    {{-- Hamburger --}}
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="p-2 rounded-xl text-slate-400 hover:text-[#39A900] dark:text-slate-500 dark:hover:text-[#39A900] hover:bg-slate-50 dark:hover:bg-slate-800 transition-all border border-slate-100 dark:border-slate-800 active:scale-90">
                        <svg x-show="!sidebarOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="sidebarOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="hidden md:flex flex-col">
                        <h3 class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none mb-0.5">Sistema de Préstamos</h3>
                        <p class="text-xs font-bold text-[#00324D] dark:text-white">{{ now()->isoFormat('dddd, D [de] MMMM YYYY') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()" 
                            class="h-9 w-9 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-500 hover:text-[#39A900] hover:bg-white dark:hover:bg-slate-700 transition-all cursor-pointer group shadow-sm">
                        <svg x-show="!darkMode" class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-4 h-4 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z"/>
                        </svg>
                    </button>
                    <!-- Notifications Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" 
                                class="relative h-9 w-9 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-500 hover:text-[#39A900] hover:bg-white dark:hover:bg-slate-700 transition-all cursor-pointer group shadow-sm">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if($pendingLoansCount > 0)
                                <span class="absolute -top-1.5 -right-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-[10px] font-black text-white ring-2 ring-white animate-pulse">
                                    {{ $pendingLoansCount }}
                                </span>
                            @endif
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-72 origin-top-right rounded-2xl bg-white dark:bg-slate-900 shadow-2xl ring-1 ring-black/5 focus:outline-none z-50 overflow-hidden border dark:border-slate-800"
                             x-cloak>
                            
                            <div class="p-4 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Notificaciones</h3>
                                    @if($pendingLoansCount > 0)
                                        <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-600 text-[9px] font-black uppercase">{{ $pendingLoansCount }} Pendientes</span>
                                    @endif
                                </div>
                            </div>

                            <div class="max-h-64 overflow-y-auto custom-scrollbar">
                                @if($pendingLoansCount > 0)
                                    <div class="p-4 group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer border-b border-slate-50 dark:border-slate-800">
                                        <div class="flex gap-3">
                                            <div class="h-8 w-8 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center flex-shrink-0 text-orange-600 dark:text-orange-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-700 dark:text-slate-200 leading-tight mb-1">Solicitudes de Préstamo</p>
                                                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-snug">Tienes <span class="text-[#39A900] font-bold">{{ $pendingLoansCount }}</span> préstamos esperando tu aprobación.</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-8 text-center text-slate-300 dark:text-slate-700">
                                        <div class="h-12 w-12 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                        </div>
                                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500">No hay notificaciones nuevas</p>
                                    </div>
                                @endif
                            </div>

                            @if($pendingLoansCount > 0)
                                <div class="p-2 bg-slate-50 dark:bg-slate-800/50">
                                    <a href="{{ route('admin.prestamos.index') }}" class="block w-full py-2 text-center text-[10px] font-black text-[#39A900] hover:bg-white dark:hover:bg-slate-800 rounded-xl transition-all uppercase tracking-widest border border-transparent hover:border-slate-100 dark:hover:border-slate-700">
                                        Gestionar Préstamos
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- User Profile - Top Right -->
                    <div class="flex items-center gap-3 pl-5 border-l border-slate-100 dark:border-slate-800">
                        <div class="text-right hidden sm:block">
                            <p class="text-[13px] font-black text-[#00324D] dark:text-white leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[#39A900] text-[9px] font-black uppercase tracking-widest leading-none">{{ Auth::user()->roles->first()->name ?? 'Administrador' }}</p>
                        </div>
                        <div class="h-10 w-10 bg-gradient-to-br from-[#39A900] to-green-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-lg border-2 border-white dark:border-slate-800 transition-transform hover:scale-110 cursor-pointer">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 bg-gray-50 dark:bg-slate-950 custom-scrollbar">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mb-2 bg-white dark:bg-slate-900 border-l-4 border-[#39A900] text-[#00324D] dark:text-white p-3 rounded-xl shadow-sm flex items-center gap-4 group transition-all animate-fade-in-down">
                        <div class="bg-[#39A900]/10 p-1.5 rounded-lg">
                            <svg class="w-5 h-5 text-[#39A900]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="font-bold text-xs tracking-tight">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-2 bg-white dark:bg-slate-900 border-l-4 border-rose-500 text-[#00324D] dark:text-white p-3 rounded-xl shadow-sm flex items-center gap-4 group transition-all animate-fade-in-down">
                        <div class="bg-rose-50 dark:bg-rose-900/20 p-1.5 rounded-lg">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="font-bold text-xs tracking-tight">{{ session('error') }}</span>
                    </div>
                @endif
                @if($errors->any() && !request()->routeIs('*.create') && !request()->routeIs('*.edit'))
                    <div class="mb-2 bg-white dark:bg-slate-900 border-l-4 border-rose-500 text-[#00324D] dark:text-white p-3 rounded-xl shadow-sm flex items-center gap-4 group transition-all animate-fade-in-down">
                        <div class="bg-rose-50 dark:bg-rose-900/20 p-1.5 rounded-lg">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <ul class="font-bold text-xs tracking-tight">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
    <script>
        // Protección contra retroceso (back button) después de cerrar sesión
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || (typeof window.performance != 'undefined' && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });

        function downloadPDF(url) {
            const btn = document.getElementById('downloadBtn');
            const icon = document.getElementById('downloadIcon');
            const loader = document.getElementById('loadingIcon');
            
            // Set loading state if the element exists (only on elements.index)
            if (btn && icon && loader) {
                btn.disabled = true;
                btn.classList.add('opacity-70', 'cursor-not-allowed');
                icon.classList.add('hidden');
                loader.classList.remove('hidden');
            }

            // Create hidden iframe
            let iframe = document.getElementById('download-iframe');
            if (!iframe) {
                iframe = document.createElement('iframe');
                iframe.id = 'download-iframe';
                // Render off-screen instead of display:none so html2canvas can capture it
                iframe.style.position = 'absolute';
                iframe.style.left = '-9999px';
                iframe.style.top = '0';
                iframe.style.width = '1024px';
                iframe.style.height = '1000px';
                iframe.style.border = 'none';
                document.body.appendChild(iframe);
            }

            // Set source to trigger generation
            iframe.src = url;

            // Simple timeout to reset button since we can't easily detect iframe download completion
            if (btn && icon && loader) {
                setTimeout(() => {
                    btn.disabled = false;
                    btn.classList.remove('opacity-70', 'cursor-not-allowed');
                    icon.classList.remove('hidden');
                    loader.classList.add('hidden');
                }, 3000);
            }
        }
    </script>
</body>
</html>
