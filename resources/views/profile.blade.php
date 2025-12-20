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

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
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
</x-layouts.app>