<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('bio', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen bg-white flex flex-col justify-between p-6 sm:justify-center sm:bg-gray-50">
    <div class="w-full max-w-sm mx-auto">
        <div class="mb-10 mt-4 sm:mt-0">
            <h1 class="text-3xl font-extrabold text-[#005461] tracking-tight">Daftar Akun</h1>
            <p class="text-gray-500 mt-2">Mulai perjalanan sehat Anda hari ini.</p>
        </div>

        <form wire:submit="register" class="space-y-5">
            <div>
                <input wire:model="name" type="text" required autofocus placeholder="Nama Lengkap"
                    class="w-full px-4 py-4 bg-gray-100 border-transparent rounded-2xl focus:bg-white focus:border-[#00B7B5] focus:ring-0 transition-all duration-200 placeholder-gray-400">
                <x-input-error :messages="$errors->get('name')" class="mt-1 ml-2 text-xs" />
            </div>

            <div>
                <input wire:model="email" type="email" required placeholder="Alamat Email"
                    class="w-full px-4 py-4 bg-gray-100 border-transparent rounded-2xl focus:bg-white focus:border-[#00B7B5] focus:ring-0 transition-all duration-200 placeholder-gray-400">
                <x-input-error :messages="$errors->get('email')" class="mt-1 ml-2 text-xs" />
            </div>

            <div>
                <input wire:model="password" type="password" required placeholder="Kata Sandi"
                    class="w-full px-4 py-4 bg-gray-100 border-transparent rounded-2xl focus:bg-white focus:border-[#00B7B5] focus:ring-0 transition-all duration-200 placeholder-gray-400">
                <x-input-error :messages="$errors->get('password')" class="mt-1 ml-2 text-xs" />
            </div>

            <div>
                <input wire:model="password_confirmation" type="password" required placeholder="Konfirmasi Sandi"
                    class="w-full px-4 py-4 bg-gray-100 border-transparent rounded-2xl focus:bg-white focus:border-[#00B7B5] focus:ring-0 transition-all duration-200 placeholder-gray-400">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 ml-2 text-xs" />
            </div>

            <div class="pt-4">
                <button
                    class="w-full bg-[#005461] text-white font-bold py-4 rounded-2xl shadow-md hover:bg-[#003a41] active:scale-[0.97] transition-all duration-150">
                    Daftar Sekarang
                </button>
            </div>
        </form>
    </div>

    <div class="text-center pb-4 sm:pt-8">
        <p class="text-sm text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#00B7B5] font-bold" wire:navigate>Masuk</a>
        </p>
    </div>
</div>
