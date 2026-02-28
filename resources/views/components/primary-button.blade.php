<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-10 py-4 bg-[#39A900] border-b-4 border-[#2d8500] rounded-2xl font-black text-xs text-white uppercase tracking-[0.2em] hover:bg-[#2d8500] active:translate-y-0.5 active:border-b-0 focus:outline-none focus:ring-8 focus:ring-green-500/20 transition-all duration-150 shadow-[0_10px_20px_-5px_rgba(57,169,0,0.4)]']) }}>
    {{ $slot }}
</button>
