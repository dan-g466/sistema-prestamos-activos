<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Sistema de Préstamo de Elementos SENA</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .swal2-popup { border-radius: 2rem !important; padding: 2rem !important; font-family: 'Segoe UI', sans-serif !important; }
        .swal2-title { font-weight: 800 !important; color: #00324D !important; text-transform: uppercase !important; font-size: 1.25rem !important; letter-spacing: -0.025em !important; }
        .swal2-html-container { font-weight: 500 !important; color: #475569 !important; font-size: 0.95rem !important; line-height: 1.5 !important; }
        .swal2-confirm { background-color: #39A900 !important; border-radius: 0.75rem !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 0.75rem !important; letter-spacing: 0.1em !important; padding: 0.8rem 2rem !important; box-shadow: 0 10px 15px -3px rgba(57, 169, 0, 0.3) !important; }
        
        /* Estilos específicos para la lista de errores en SweetAlert */
        .swal2-html-container ul { list-style: none; padding: 0; margin: 10px 0; }
        .swal2-html-container li { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 8px; text-align: left; }
        .swal2-html-container li i { color: #f43f5e; margin-top: 3px; font-size: 0.9em; }
    </style>

    <style>
        /* Reseteo básico (Adaptado del snippet del usuario) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            /* Verde SENA más claro para dejar ver la imagen de fondo */
            background-image: linear-gradient(135deg, rgba(57, 169, 0, 0.7), rgba(44, 130, 0, 0.75)), url('/img/login.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-section {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        .sena-logo {
            width: 80px;
            margin: 0 auto 15px;
            filter: brightness(0) invert(1) drop-shadow(0 8px 15px rgba(0,0,0,0.3));
        }

        .header-section h1 {
            font-size: 22px;
            font-weight: 800;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .login-card {
            background-color: #ffffff;
            border-radius: 24px;
            padding: 25px 35px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            position: relative;
            overflow: hidden;
        }

        /* Detalle decorativo superior */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, #39A900, #00324D);
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        /* Íconos dentro de los inputs */
        .icon-left {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .input-group:focus-within .icon-left {
            color: #39A900;
        }

        .icon-right {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .icon-right:hover {
            color: #39A900;
            transform: translateY(-50%) scale(1.1);
        }

        .input-group input {
            width: 100%;
            padding: 16px 45px;
            border: 2px solid #f1f5f9;
            border-radius: 14px;
            font-size: 15px;
            color: #1e293b;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: #f8fafc;
        }

        .input-group input:focus {
            border-color: #39A900;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.1);
        }

        .btn-ingresar {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #39A900, #2c8200);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 20px -5px rgba(57, 169, 0, 0.4);
        }

        .btn-ingresar:hover {
            background: linear-gradient(135deg, #2c8200, #226205);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -10px rgba(57, 169, 0, 0.6);
        }

        .btn-ingresar:active {
            transform: translateY(0);
        }

        .enlaces-ayuda {
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 12px;
        }

        .enlaces-ayuda a {
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .enlaces-ayuda a:hover {
            color: #39A900;
            padding-left: 5px;
        }

        /* Estilos para errores de validación de Laravel */
        .mt-2-err {
            font-size: 11px;
            color: #e53e3e;
            text-align: left;
            margin-top: 5px;
            font-weight: 600;
            list-style: none;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 transition-colors duration-300" 
      x-data="{ 
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
    
    <!-- Theme Toggle Fixed -->
    <button @click="toggleTheme()" 
            class="fixed top-6 right-6 h-12 w-12 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white hover:bg-white/40 transition-all cursor-pointer group shadow-lg z-50">
        <svg x-show="!darkMode" class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
        </svg>
        <svg x-show="darkMode" class="w-6 h-6 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z"/>
        </svg>
    </button>

    <div class="login-wrapper">
        <div class="header-section">
            <img src="/img/logo.png" alt="Logo SENA" class="sena-logo">
            <h1 class="dark:text-white">Sistema de Préstamo<br>de Elementos SENA</h1>
        </div>

        <div class="login-card dark:bg-slate-900 border dark:border-slate-800">
            {{ $slot }}
        </div>
    </div>
</body>
</html>

