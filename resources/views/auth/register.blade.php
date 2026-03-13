<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="input-group mb-4">
            <i class="fa-solid fa-signature icon-left"></i>
            <input id="name" type="text" name="name" :value="old('name')" 
                placeholder="Nombre Completo" required autofocus autocomplete="name" style="padding: 12px 45px;" />
            <x-input-error :messages="$errors->get('name')" class="mt-2-err" />
        </div>

        <!-- Documento -->
        <div class="input-group mb-4">
            <i class="fa-solid fa-id-card icon-left"></i>
            <input id="documento" type="text" name="documento" :value="old('documento')" 
                placeholder="Número de Documento" required autocomplete="username" style="padding: 12px 45px;" 
                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                title="Solo se aceptan caracteres numéricos" />
            <p style="font-size: 10px; color: #94a3b8; margin-top: 5px; margin-left: 5px;">
                <i class="fa-solid fa-circle-info mr-1"></i> Solo caracteres numéricos
            </p>
            <x-input-error :messages="$errors->get('documento')" class="mt-2-err" />
        </div>

        <!-- Email Address -->
        <div class="input-group mb-4">
            <i class="fa-solid fa-envelope icon-left"></i>
            <input id="email" type="email" name="email" :value="old('email')" 
                placeholder="Correo Electrónico" required autocomplete="username" style="padding: 12px 45px;" />
            <x-input-error :messages="$errors->get('email')" class="mt-2-err" />
        </div>

        <!-- Password -->
        <div class="input-group mb-4">
            <i class="fa-solid fa-lock icon-left"></i>
            <input id="password" type="password" name="password" 
                placeholder="Contraseña" required autocomplete="new-password" style="padding: 12px 45px;" />
            <x-input-error :messages="$errors->get('password')" class="mt-2-err" />
        </div>

        <!-- Confirm Password -->
        <div class="input-group mb-4">
            <i class="fa-solid fa-shield icon-left"></i>
            <input id="password_confirmation" type="password" name="password_confirmation" 
                placeholder="Confirmar Contraseña" required autocomplete="new-password" style="padding: 12px 45px;" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2-err" />
        </div>

        <div class="pt-0">
            <button type="submit" class="btn-ingresar" style="background: linear-gradient(135deg, #39A900, #2c8200); border-bottom: 4px solid #1a4d00; text-shadow: 0 2px 4px rgba(0,0,0,0.2); padding: 12px;">
                <i class="fa-solid fa-user-plus mr-2 text-xs"></i>
                <span class="text-xs uppercase tracking-widest">Crear mi cuenta</span>
            </button>

            <div class="enlaces-ayuda" style="margin-top: 20px; padding-top: 15px;">
                <a href="{{ route('login') }}" class="text-[12px]">
                    <i class="fa-solid fa-arrow-left-long mr-1"></i>
                    ¿Ya tienes una cuenta? Iniciar Sesión
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
