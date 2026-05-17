<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Back Button -->
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-brand-green transition-colors mb-8" wire:navigate>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Beranda
    </a>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">SELAMAT DATANG!</h1>
    </div>

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="E-mail" 
                   class="w-full px-6 py-4 bg-gray-200/70 border-none rounded-full text-gray-800 placeholder-gray-500 focus:ring-2 focus:ring-brand-green outline-none font-semibold transition-all" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" 
                   class="w-full px-6 py-4 bg-gray-200/70 border-none rounded-full text-gray-800 placeholder-gray-500 focus:ring-2 focus:ring-brand-green outline-none font-semibold transition-all" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div class="flex justify-end pt-1">
            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-brand-green hover:text-green-600 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-1/2 mx-auto flex justify-center py-3.5 px-4 border border-transparent rounded-2xl shadow-[0_4px_14px_0_rgba(126,211,33,0.39)] text-lg font-bold text-white bg-brand-green hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-green transition-all transform hover:-translate-y-0.5">
                Login
            </button>
        </div>
        
        <!-- Remember Me (Hidden to match design exactly while keeping functionality if needed) -->
        <div class="hidden">
            <input wire:model="form.remember" id="remember" type="checkbox" name="remember">
        </div>
    </form>

    <div class="mt-10">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-brand-green/30"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-brand-cream text-brand-green font-semibold">Atau</span>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-4">
            <button type="button" class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-full shadow-sm bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="h-5 w-5 mr-2">
                Google
            </button>
            <button type="button" class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-full shadow-sm bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook" class="h-5 w-5 mr-2">
                Facebook
            </button>
        </div>
    </div>

    <div class="mt-10 text-center">
        <p class="text-sm text-gray-500 font-medium">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-brand-green hover:text-green-600 transition-colors" wire:navigate>Daftar sekarang</a>
        </p>
    </div>
</div>
