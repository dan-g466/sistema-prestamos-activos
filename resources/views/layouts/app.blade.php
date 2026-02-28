<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Préstamos - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50 font-sans" x-data="{ menuOpen: false }">
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('index') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                    <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-sm border border-gray-100 p-2">
                        <img src="/img/logo.png" alt="Logo SENA" class="w-full h-full object-contain">
                    </div>
                    <span class="text-xl font-black text-gray-800 uppercase tracking-tighter">Préstamos <span class="text-[#39A900]">SENA</span></span>
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
                    <span class="hidden md:block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
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
        <div x-show="menuOpen" class="md:hidden bg-white border-t px-4 py-3 space-y-1">
            <a href="{{ route('user.dashboard') }}" class="flex items-center justify-between py-2 text-sm font-semibold text-gray-700 hover:text-indigo-700">
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
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
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
