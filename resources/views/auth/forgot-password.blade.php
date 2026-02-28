<x-guest-layout>
    <div class="mb-6 text-[13px] text-slate-500 leading-relaxed text-center px-4 font-medium italic">
        {{ __('¿Olvidaste tu contraseña? No te preocupes. Ingresa tu correo y te enviaremos un enlace para que elijas una nueva.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-group mb-6">
            <i class="fa-solid fa-envelope icon-left"></i>
            <input id="email" type="email" name="email" :value="old('email')" 
                placeholder="Correo Electrónico Institucional" required autofocus style="padding: 14px 45px;" />
            <x-input-error :messages="$errors->get('email')" class="mt-2-err" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-ingresar" style="background: linear-gradient(135deg, #39A900, #2c8200); border-bottom: 4px solid #1a4d00; text-shadow: 0 2px 4px rgba(0,0,0,0.2); padding: 14px;">
                <i class="fa-solid fa-paper-plane mr-2 text-xs"></i>
                <span class="text-xs uppercase tracking-widest">Enviar enlace de rescate</span>
            </button>

            <div class="enlaces-ayuda" style="margin-top: 25px; padding-top: 15px;">
                <a href="{{ route('login') }}" class="text-[12px]">
                    <i class="fa-solid fa-arrow-left-long mr-1"></i>
                    Volver al Inicio de Sesión
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
