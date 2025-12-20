<div class="min-h-screen bg-white p-6">
    <div class="max-w-sm mx-auto">
        <div class="mt-8 mb-10">
            <h1 class="text-3xl font-extrabold text-[#005461] tracking-tight">Data Diri</h1>
            <p class="text-gray-500 mt-2">Lengkapi informasi pribadi Anda.</p>
        </div>

        @if (session('status'))
            <div
                class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-2xl text-sm font-medium border border-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-8">
            {{-- Gender Selection --}}
            <div class="relative">
                <label class="block text-xs font-bold text-[#005461] uppercase tracking-widest mb-4 ml-1">
                    Jenis Kelamin
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="gender" value="male" class="peer sr-only">
                        <div
                            class="flex items-center justify-center h-20 rounded-2xl border-2 border-gray-200 peer-checked:border-[#00B7B5] peer-checked:bg-teal-50 transition-all">
                            <div class="text-center">
                                <div class="text-3xl mb-1">👨</div>
                                <div class="text-sm font-semibold text-gray-700">Laki-laki</div>
                            </div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="gender" value="female" class="peer sr-only">
                        <div
                            class="flex items-center justify-center h-20 rounded-2xl border-2 border-gray-200 peer-checked:border-[#00B7B5] peer-checked:bg-teal-50 transition-all">
                            <div class="text-center">
                                <div class="text-3xl mb-1">👩</div>
                                <div class="text-sm font-semibold text-gray-700">Perempuan</div>
                            </div>
                        </div>
                    </label>
                </div>
                @error('gender')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            {{-- Weight Input --}}
            <div class="relative">
                <label class="block text-xs font-bold text-[#005461] uppercase tracking-widest mb-2 ml-1">
                    Berat Badan
                </label>
                <div class="flex items-center">
                    <input wire:model="weight" type="number" step="0.1" placeholder="00.0"
                        class="w-full text-4xl font-light py-4 border-b-2 border-gray-100 focus:border-[#00B7B5] focus:ring-0 transition-all placeholder-gray-200">
                    <span class="text-xl font-medium text-gray-400 ml-4">kg</span>
                </div>
                @error('weight')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            {{-- Height Input --}}
            <div class="relative">
                <label class="block text-xs font-bold text-[#005461] uppercase tracking-widest mb-2 ml-1">
                    Tinggi Badan
                </label>
                <div class="flex items-center">
                    <input wire:model="height" type="number" placeholder="000"
                        class="w-full text-4xl font-light py-4 border-b-2 border-gray-100 focus:border-[#00B7B5] focus:ring-0 transition-all placeholder-gray-200">
                    <span class="text-xl font-medium text-gray-400 ml-4">cm</span>
                </div>
                @error('height')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="pt-6">
                <button type="submit"
                    class="w-full bg-[#00B7B5] text-white font-bold py-5 rounded-2xl shadow-lg shadow-teal-100 hover:bg-[#009a98] active:scale-[0.97] transition-all">
                    Simpan Perubahan
                </button>

                <a href="{{ route('dashboard') }}"
                    class="block text-center mt-6 text-sm font-medium text-gray-400 hover:text-[#005461]">
                    Nanti Saja
                </a>
            </div>
        </form>
    </div>
</div>
