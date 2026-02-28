<x-guest-layout>
    <div class="mb-6 text-[13px] text-slate-500 leading-relaxed text-center px-4 font-medium italic">
        {{ __('Crea una nueva contraseña para tu cuenta. Asegúrate de que sea segura.') }}
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="input-group mb-4">
            <i class="fa-solid fa-envelope icon-left"></i>
            <input id="email" type="email" name="email" :value="old('email', $request->email)" 
                placeholder="Correo Electrónico" required autofocus autocomplete="username" style="padding: 12px 45px;" />
            <x-input-error :messages="$errors->get('email')" class="mt-2-err" />
        </div>

        <!-- Password -->
        <div class="input-group mb-4">
            <i class="fa-solid fa-lock icon-left"></i>
            <input id="password" type="password" name="password" 
                placeholder="Nueva Contraseña" required autocomplete="new-password" style="padding: 12px 45px;" />
            <x-input-error :messages="$errors->get('password')" class="mt-2-err" />
        </div>

        <!-- Confirm Password -->
        <div class="input-group mb-6">
            <i class="fa-solid fa-shield icon-left"></i>
            <input id="password_confirmation" type="password" name="password_confirmation" 
                placeholder="Confirmar Nueva Contraseña" required autocomplete="new-password" style="padding: 12px 45px;" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2-err" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-ingresar" style="background: linear-gradient(135deg, #39A900, #2c8200); border-bottom: 4px solid #1a4d00; text-shadow: 0 2px 4px rgba(0,0,0,0.2); padding: 14px;">
                <i class="fa-solid fa-key mr-2 text-xs"></i>
                <span class="text-xs uppercase tracking-widest">Restablecer Contraseña</span>
            </button>
        </div>
    </form>
</x-guest-layout>
