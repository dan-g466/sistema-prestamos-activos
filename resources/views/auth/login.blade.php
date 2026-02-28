<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username / Documento -->
        <div class="input-group">
            <i class="fa-regular fa-user icon-left"></i>
            <input type="text" id="login" name="login" :value="old('login')" placeholder="Usuario (DNI)" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('login')" class="mt-2-err" />
        </div>

        <!-- Password -->
        <div class="input-group">
            <i class="fa-solid fa-lock icon-left"></i>
            <input type="password" id="password" name="password" placeholder="Contraseña" required autocomplete="current-password">
            <i class="fa-regular fa-eye-slash icon-right" id="togglePassword" title="Mostrar/Ocultar contraseña"></i>
            <x-input-error :messages="$errors->get('password')" class="mt-2-err" />
        </div>

        <button type="submit" class="btn-ingresar">Ingresar</button>

        <div class="enlaces-ayuda">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">¿Olvidó su contraseña?</a>
            @endif
            
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Registrarse</a>
            @endif
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script para mostrar/ocultar la contraseña
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            if (togglePassword && password) {
                togglePassword.addEventListener('click', function () {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            // SweetAlert para errores de ingreso
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: '¡Error de Acceso!',
                    html: `
                        <div class="text-left mt-2">
                            <ul class="space-y-2">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-exclamation text-rose-500 mt-1"></i>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    `,
                    confirmButtonText: 'ENTENDIDO',
                    timer: 6000,
                    timerProgressBar: true
                });
            @endif
        });
    </script>
</x-guest-layout>
