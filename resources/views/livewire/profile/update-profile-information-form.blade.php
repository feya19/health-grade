<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public ?string $gender = null;
    public ?float $weight = null;
    public ?float $height = null;
    public ?string $dateOfBirth = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->gender = $user->gender;
        $this->weight = $user->berat_badan;
        $this->height = $user->tinggi_badan;
        $this->dateOfBirth = $user->date_of_birth?->format('Y-m-d');
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'gender' => ['nullable', 'in:male,female'],
            'weight' => ['nullable', 'numeric', 'min:20', 'max:300'],
            'height' => ['nullable', 'numeric', 'min:50', 'max:250'],
            'dateOfBirth' => ['nullable', 'date', 'before:today'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'berat_badan' => $validated['weight'],
            'tinggi_badan' => $validated['height'],
            'date_of_birth' => $validated['dateOfBirth'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" class="!text-gray-700" />
            
            <x-text-input wire:model="name" id="name" name="name" type="text" 
                class="mt-1 block w-full !bg-white !text-gray-900 !border-gray-300 focus:!border-hg-primary focus:!ring-hg-primary" 
                required autofocus autocomplete="name" />
            
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="!text-gray-700" />
            
            <x-text-input disabled wire:model="email" id="email" name="email" type="email" 
                class="mt-1 block w-full !bg-gray-100 !text-gray-900 !border-gray-300 focus:!border-hg-primary focus:!ring-hg-primary" 
                required autocomplete="username" />
            
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-hg-primary">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Gender --}}
        <div>
            <x-input-label for="gender" :value="__('Gender')" class="!text-gray-700" />
            <select wire:model="gender" id="gender" name="gender" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-hg-primary focus:ring-hg-primary">
                <option value="">Pilih Gender</option>
                <option value="male">Laki-laki</option>
                <option value="female">Perempuan</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        {{-- Weight & Height --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="weight" :value="__('Berat Badan (kg)')" class="!text-gray-700" />
                <x-text-input wire:model="weight" id="weight" name="weight" type="number" step="0.1" min="20" max="300"
                    class="mt-1 block w-full !bg-white !text-gray-900 !border-gray-300 focus:!border-hg-primary focus:!ring-hg-primary" 
                    placeholder="60" />
                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
            </div>
            <div>
                <x-input-label for="height" :value="__('Tinggi Badan (cm)')" class="!text-gray-700" />
                <x-text-input wire:model="height" id="height" name="height" type="number" step="0.1" min="50" max="250"
                    class="mt-1 block w-full !bg-white !text-gray-900 !border-gray-300 focus:!border-hg-primary focus:!ring-hg-primary" 
                    placeholder="165" />
                <x-input-error class="mt-2" :messages="$errors->get('height')" />
            </div>
        </div>

        {{-- Date of Birth --}}
        <div>
            <x-input-label for="dateOfBirth" :value="__('Tanggal Lahir')" class="!text-gray-700" />
            <x-text-input wire:model="dateOfBirth" id="dateOfBirth" name="dateOfBirth" type="date"
                class="mt-1 block w-full !bg-white !text-gray-900 !border-gray-300 focus:!border-hg-primary focus:!ring-hg-primary" />
            <x-input-error class="mt-2" :messages="$errors->get('dateOfBirth')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="!bg-hg-primary hover:!bg-hg-secondary focus:!bg-hg-secondary active:!bg-hg-dark">
                {{ __('Save') }}
            </x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>