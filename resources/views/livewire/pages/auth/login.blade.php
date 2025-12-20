<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen bg-white flex flex-col justify-between p-6 sm:justify-center sm:bg-gray-50">
    <div class="w-full max-w-sm mx-auto">
        <div class="mb-10 mt-8 sm:mt-0 text-center">
            <h1 class="text-3xl font-extrabold text-[#005461] tracking-tight">Masuk</h1>
            <p class="text-gray-500 mt-2">Gunakan akun Anda untuk melanjutkan</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="login" class="space-y-6">
            <div>
                <input wire:model="form.email" type="email" required autofocus placeholder="Alamat Email"
                    class="w-full px-4 py-4 bg-gray-100 border-transparent rounded-2xl focus:bg-white focus:border-[#00B7B5] focus:ring-0 transition-all duration-200 placeholder-gray-400">
                <x-input-error :messages="$errors->get('form.email')" class="mt-1 ml-2" />
            </div>

            <div class="space-y-1">
                <input wire:model="form.password" type="password" required placeholder="Kata Sandi"
                    class="w-full px-4 py-4 bg-gray-100 border-transparent rounded-2xl focus:bg-white focus:border-[#00B7B5] focus:ring-0 transition-all duration-200 placeholder-gray-400">
                <x-input-error :messages="$errors->get('form.password')" class="mt-1 ml-2" />

                <div class="flex justify-end pr-2">
                    @if (Route::has('password.request'))
                        <a class="text-xs font-medium text-[#005461]" href="{{ route('password.request') }}"
                            wire:navigate>
                            Lupa sandi?
                        </a>
                    @endif
                </div>
            </div>

            <button
                class="w-full bg-[#005461] text-white font-bold py-4 rounded-2xl shadow-md hover:bg-[#003a41] active:scale-[0.97] transition-all duration-150">
                Masuk
            </button>

            <div class="relative py-2">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-100"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase"><span
                        class="bg-white px-2 text-gray-400">Atau</span></div>
            </div>

            <a href="{{ route('google.redirect') }}"
                class="flex items-center justify-center w-full py-4 border border-gray-200 rounded-2xl font-semibold text-gray-600 hover:bg-gray-50 active:scale-[0.97] transition-all duration-150">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 mr-3" alt="Google">
                Google
            </a>
        </form>
    </div>

    <div class="text-center pb-4 sm:pt-8">
        <p class="text-sm text-gray-500">
            Belum punya akun?
            <a href="/register" class="text-[#00B7B5] font-bold">Daftar</a>
        </p>
    </div>
</div>
