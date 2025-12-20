<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-hg-dark leading-tight">
                {{ __('Pengaturan Akun') }}
            </h2>
            <a href="{{ route('dashboard') }}" wire:navigate class="text-sm text-gray-500 hover:text-hg-primary transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    {{-- Added pb-28 to ensure content isn't hidden behind the bottom nav --}}
    <div class="py-12 pb-28">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Profile Information Card --}}
            <div class="p-6 md:p-10 bg-white shadow-sm border border-gray-100 rounded-3xl relative overflow-hidden">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-hg-primary/10 flex items-center justify-center text-hg-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-hg-dark">Informasi Profil</h3>
                        <p class="text-sm text-gray-500">Perbarui informasi profil akun dan alamat email Anda.</p>
                    </div>
                </div>
                
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            {{-- Update Password Card --}}
            <div class="p-6 md:p-10 bg-white shadow-sm border border-gray-100 rounded-3xl">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-hg-dark">Keamanan Password</h3>
                        <p class="text-sm text-gray-500">Pastikan akun Anda tetap aman dengan menggunakan password yang kuat.</p>
                    </div>
                </div>

                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            {{-- Logout Button (Optional but useful for Mobile PWA flow) --}}
            <div class="md:hidden">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-between p-4 bg-white border border-gray-100 shadow-sm rounded-3xl text-red-500 font-bold hover:bg-red-50 transition">
                        <span>Keluar Akun</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>

            {{-- Delete Account Card --}}
            <div class="p-6 md:p-10 bg-red-50/30 shadow-sm border border-red-100 rounded-3xl">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-red-700">Hapus Akun</h3>
                        <p class="text-sm text-red-500/80">Setelah akun dihapus, semua data akan hilang secara permanen.</p>
                    </div>
                </div>

                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
            
        </div>
    </div>

    {{-- BOTTOM NAVIGATION BAR (Fixed) --}}
    <div class="fixed bottom-0 w-full bg-white border-t border-gray-100 px-6 py-3 pb-safe z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.03)] rounded-t-[2rem]">
        <div class="flex justify-between items-center max-w-lg mx-auto relative">
            
            {{-- Home --}}
            <a href="{{ route('dashboard') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] font-medium">Home</span>
            </a>

            {{-- History --}}
            <a href="{{ route('history') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>

            {{-- SCAN BUTTON (Center Floating) --}}
            <div class="relative -top-8">
                <a href="{{ route('scan.barcode') }}" wire:navigate class="flex items-center justify-center w-16 h-16 bg-hg-dark rounded-full text-white shadow-xl shadow-hg-primary/40 border-4 border-hg-light hover:scale-105 transition transform active:scale-95">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </a>
            </div>

            {{-- AI Assistant --}}
            <a href="{{ route('assistant') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                <span class="text-[10px] font-medium">Asisten</span>
            </a>

            {{-- Profile (Active Context) --}}
            <a href="#" class="flex flex-col items-center gap-1 text-hg-primary">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <span class="text-[10px] font-bold">Profil</span>
            </a>

        </div>
    </div>

</x-layouts.app>