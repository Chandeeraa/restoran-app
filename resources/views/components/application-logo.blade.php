<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-center']) }}>
    @if(file_exists(public_path('img/logo.png')))
        <img src="{{ asset('img/logo.png') }}" 
             alt="YON RESTO" 
             class="h-16 w-auto object-contain mix-blend-multiply dark:mix-blend-screen dark:invert opacity-90 drop-shadow-sm">
    @else
        <i class="fa-solid fa-mug-hot text-[#5c3a21] dark:text-amber-500 text-3xl mb-1 drop-shadow-sm"></i>
        <span class="font-serif font-bold text-xl tracking-widest text-[#5c3a21] dark:text-amber-400">YON RESTO</span>
        <span class="text-[10px] font-bold tracking-widest text-[#5c3a21]/80 dark:text-amber-500/80 uppercase mt-1">Specialty Coffee & Resto</span>
    @endif
</div>
