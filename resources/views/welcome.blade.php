<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sistema de Préstamos SENA') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Variables de color institucionales */
        :root {
            --sena-green: #39A900;
            --sena-dark-green: #2F8B00;
            --sena-white: #FFFFFF;
            --text-dark: #333333;
            --bg-light: #F8F9FA;
        }

        /* Reseteo básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }

        body {
            background-color: var(--sena-white);
            color: var(--text-dark);
            scroll-behavior: smooth;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        ul {
            list-style: none;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- Header y Navegación --- */
        header {
            background-color: var(--sena-white);
            padding: 15px 0;
            border-bottom: 1px solid #EEEEEE;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Espacio para el logo del SENA */
        .logo-placeholder {
            font-size: 24px;
            font-weight: 800;
            color: var(--sena-green);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo-placeholder img {
            height: 45px;
            width: auto;
        }

        nav ul {
            display: flex;
            gap: 30px;
        }

        nav a {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            text-transform: uppercase;
        }

        nav a:hover {
            color: var(--sena-green);
        }

        .btn-header-login {
            background-color: var(--sena-green);
            color: var(--sena-white);
            padding: 10px 28px;
            border-radius: 25px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 14px;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(57, 169, 0, 0.2);
        }

        .btn-header-login:hover {
            background-color: var(--sena-dark-green);
            color: var(--sena-white);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(57, 169, 0, 0.3);
        }

        /* --- Sección Principal (Hero) --- */
        .hero {
            padding: 100px 0;
            background-color: var(--sena-white);
        }

        .hero .container {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-text h1 {
            font-size: 52px;
            color: var(--sena-green);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        .hero-text p {
            font-size: 19px;
            color: #555;
            margin-bottom: 45px;
            line-height: 1.7;
        }

        .btn-main {
            background-color: var(--sena-green);
            color: var(--sena-white);
            padding: 18px 45px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 17px;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 8px 30px rgba(57, 169, 0, 0.3);
            text-transform: uppercase;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-main:hover {
            background-color: var(--sena-dark-green);
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 35px rgba(57, 169, 0, 0.4);
        }

        .hero-image {
            position: relative;
            padding-left: 20px;
        }

        .hero-image img {
            width: 100%;
            height: auto;
            border-radius: 24px;
            filter: drop-shadow(0 30px 60px rgba(0,0,0,0.12));
            transition: all 0.5s ease;
        }
        
        .hero-image:hover img {
            transform: translateY(-10px);
        }

        /* --- Sección de Características --- */
        .features {
            padding: 120px 0;
            background-color: var(--bg-light);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 35px;
        }

        .feature-card {
            background-color: var(--sena-white);
            padding: 50px 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.04);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid rgba(0,0,0,0.02);
            border-bottom: 5px solid #EEEEEE;
        }

        .feature-card:hover {
            transform: translateY(-15px);
            border-bottom: 5px solid var(--sena-green);
            box-shadow: 0 30px 60px rgba(0,0,0,0.1);
        }

        .icon-wrapper {
            width: 85px;
            height: 85px;
            background-color: rgba(57, 169, 0, 0.08);
            border-radius: 22px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 30px;
            transform: rotate(-6deg);
            transition: all 0.4s ease;
        }

        .feature-card:hover .icon-wrapper {
            transform: rotate(0deg) scale(1.1);
            background-color: var(--sena-green);
            box-shadow: 0 10px 20px rgba(57, 169, 0, 0.2);
        }

        .feature-card i {
            font-size: 36px;
            color: var(--sena-green);
            transition: all 0.4s ease;
        }

        .feature-card:hover i {
            color: white;
        }

        .feature-card h3 {
            font-size: 21px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .feature-card p {
            font-size: 16px;
            color: #666;
            line-height: 1.7;
        }

        /* --- Footer --- */
        footer {
            padding: 60px 0;
            text-align: center;
            background-color: #fcfcfc;
            border-top: 1px solid #EEEEEE;
            font-size: 15px;
            color: #777;
        }
        
        footer b {
            color: var(--sena-green);
        }

        /* --- Responsividad --- */
        @media (max-width: 1200px) {
            .hero-text h1 { font-size: 44px; }
        }

        @media (max-width: 992px) {
            .hero .container {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 50px;
            }
            .hero-text h1 { font-size: 40px; }
            .hero-image { order: -1; padding-left: 0; }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
            .btn-main { justify-content: center; }
        }

        @media (max-width: 768px) {
            header .container { flex-direction: column; gap: 20px; text-align: center; }
            nav ul { flex-wrap: wrap; justify-content: center; gap: 20px; margin-bottom: 10px; }
            .features-grid { grid-template-columns: 1fr; }
            .hero { padding: 50px 0; }
            .hero-text h1 { font-size: 34px; }
        }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <div class="logo-placeholder">
                <img src="{{ asset('img/logo.png') }}" alt="Logo SENA">
                <span>SENA</span>
            </div>
            
            @if (Route::has('login'))
                <nav>
                    <ul>
                        <li><a href="#inicio">Inicio</a></li>
                        <li><a href="#caracteristicas">Características</a></li>
                        @auth
                            <li><a href="{{ Auth::user()->hasRole('Lider Admin') ? route('admin.dashboard') : route('user.dashboard') }}">Mi Panel</a></li>
                        @endauth
                    </ul>
                </nav>
                
                <div class="auth-buttons">
                    @auth
                        <a href="{{ Auth::user()->hasRole('Lider Admin') ? route('admin.dashboard') : route('user.dashboard') }}" class="btn-header-login">
                            Ir al Panel <i class="fas fa-chevron-right" style="margin-left: 8px;"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-header-login">Iniciar Sesión</a>
                    @endauth
                </div>
            @endif
        </div>
    </header>

    <main>
        <section class="hero" id="inicio">
            <div class="container">
                <div class="hero-text">
                    <h1>SISTEMA DE PRÉSTAMO DE ELEMENTOS SENA</h1>
                    <p>La solución definitiva para la gestión eficiente de inventarios y préstamos de equipos en centros de formación. Control total al alcance de tu mano.</p>
                    
                    @auth
                         <a href="{{ Auth::user()->hasRole('Lider Admin') ? route('admin.dashboard') : route('user.dashboard') }}" class="btn-main">
                            Ir a mi Dashboard <i class="fas fa-arrow-right"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-main">
                            Ingresar al Sistema <i class="fas fa-sign-in-alt"></i>
                        </a>
                    @endauth
                </div>
                <div class="hero-image">
                    <img src="{{ asset('img/inicio.png') }}" alt="Ilustración Taller SENA">
                </div>
            </div>
        </section>

        <section class="features" id="caracteristicas">
            <div class="container">
                <div class="features-grid">
                    <article class="feature-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h3>CONTROL DE INVENTARIO</h3>
                        <p>Supervise en tiempo real la ubicación, estado y disponibilidad de cada herramienta y equipo de su centro.</p>
                    </article>
                    
                    <article class="feature-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3>RESERVAS FÁCILES</h3>
                        <p>Simplifique el proceso de solicitud para aprendices e instructores con un sistema de reservas intuitivo.</p>
                    </article>
                    
                    <article class="feature-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <h3>REPORTES DETALLADOS</h3>
                        <p>Automatice sus informes de uso, gestione devoluciones tardías y mantenga un historial completo sin esfuerzo.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} <b>Sistema de Préstamos SENA</b>. Diseñado para la excelencia en formación profesional.</p>
        </div>
    </footer>

</body>
</html>
