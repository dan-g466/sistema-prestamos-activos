<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-8 py-3.5 bg-white border-2 border-[#39A900] rounded-2xl font-black text-xs text-[#39A900] uppercase tracking-[0.1em] shadow-md hover:bg-[#39A900]/5 focus:outline-none focus:ring-4 focus:ring-green-500/10 disabled:opacity-25 active:scale-[0.98] transition-all duration-200']) }}>
    {{ $slot }}
</button>
