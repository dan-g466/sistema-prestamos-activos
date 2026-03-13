<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Préstamos - SENA</title>
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
</head>

<body class="bg-gray-50 dark:bg-slate-950 font-sans transition-colors duration-300" 
      x-data="{ 
        menuOpen: false,
        darkMode: localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
        toggleTheme() {
            this.darkMode = !this.darkMode;
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        }
      }">
    <nav class="bg-white dark:bg-slate-900 shadow-sm border-b border-gray-200 dark:border-slate-800">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('index') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                    <div class="w-14 h-14 bg-white dark:bg-slate-800 rounded-xl flex items-center justify-center shadow-sm border border-gray-100 dark:border-slate-700 p-2">
                        <img src="/img/logo.png" alt="Logo SENA" class="w-full h-full object-contain">
                    </div>
                    <span class="text-xl font-black text-gray-800 dark:text-white uppercase tracking-tighter">Préstamos <span class="text-[#39A900]">SENA</span></span>
                </a>

                <div class="hidden md:flex items-center space-x-1 text-sm font-semibold">
                    <a href="{{ route('user.dashboard') }}"
                       class="px-4 py-2 rounded-lg {{ request()->routeIs('user.dashboard') ? 'bg-indigo-700 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition flex items-center gap-2">
                       Inicio
                       @if(Auth::user()->unreadNotifications->count() > 0)
                           <span class="flex h-2 w-2 rounded-full bg-rose-500 animate-pulse"></span>
                       @endif
                    </a>
                    <a href="{{ route('user.catalogo') }}"
                       class="px-4 py-2 rounded-lg {{ request()->routeIs('user.catalogo') ? 'bg-indigo-700 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition">
                       Catálogo
                    </a>
                    <a href="{{ route('user.historial') }}"
                       class="px-4 py-2 rounded-lg {{ request()->routeIs('user.historial') ? 'bg-indigo-700 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition">
                       Mis Préstamos
                    </a>
                    <a href="{{ route('user.sanciones.index') }}"
                       class="px-4 py-2 rounded-lg {{ request()->routeIs('user.sanciones.index') ? 'bg-indigo-700 text-white' : 'text-gray-600 hover:bg-gray-100' }} transition">
                       Mis Sanciones
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()" 
                            class="h-9 w-9 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-500 hover:text-[#39A900] dark:hover:text-[#39A900] transition-all cursor-pointer group shadow-sm">
                        <svg x-show="!darkMode" class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-4 h-4 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z"/>
                        </svg>
                    </button>
                    <span class="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 transition">
                            Salir
                        </button>
                    </form>
                    <button @click="menuOpen = !menuOpen" class="md:hidden text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!menuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="menuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div x-show="menuOpen" class="md:hidden bg-white dark:bg-slate-900 border-t dark:border-slate-800 px-4 py-3 space-y-1">
            <a href="{{ route('user.dashboard') }}" class="flex items-center justify-between py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-indigo-700 dark:hover:text-[#39A900]">
                Inicio
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="bg-rose-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ Auth::user()->unreadNotifications->count() }}</span>
                @endif
            </a>
            <a href="{{ route('user.catalogo') }}" class="block py-2 text-sm font-semibold text-gray-700 hover:text-indigo-700">Catálogo</a>
            <a href="{{ route('user.historial') }}" class="block py-2 text-sm font-semibold text-gray-700 hover:text-indigo-700">Mis Préstamos</a>
            <a href="{{ route('user.sanciones.index') }}" class="block py-2 text-sm font-semibold text-gray-700 hover:text-indigo-700">Mis Sanciones</a>
        </div>
    </nav>

    @isset($header)
        <header class="bg-white dark:bg-slate-900 shadow-sm border-b dark:border-slate-800">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="dark:text-white">
                    {{ $header }}
                </div>
            </div>
        </header>
    @endisset

    <main>
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-lg text-sm font-semibold">
                    ✓ {{ session('success') }}
                </div>
            </div>
        @endif
        {{ $slot }}
    </main>
</body>
</html>
