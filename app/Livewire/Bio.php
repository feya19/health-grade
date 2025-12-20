<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Bio extends Component
{
    public $gender;
    public $weight;
    public $height;
    public $dateOfBirth;

    public function mount()
    {
        $this->gender = Auth::user()->gender;
        $this->weight = Auth::user()->berat_badan;
        $this->height = Auth::user()->tinggi_badan;
        $this->dateOfBirth = Auth::user()->date_of_birth?->format('Y-m-d');
    }

    public function save()
    {
        $this->validate([
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:20|max:300',
            'height' => 'required|numeric|min:50|max:250',
            'dateOfBirth' => 'required|date|before:today|after:' . now()->subYears(100)->format('Y-m-d'),
        ], [
            'dateOfBirth.required' => 'Tanggal lahir wajib diisi.',
            'dateOfBirth.date' => 'Format tanggal tidak valid.',
            'dateOfBirth.before' => 'Tanggal lahir harus sebelum hari ini.',
            'dateOfBirth.after' => 'Tanggal lahir tidak valid.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'gender' => $this->gender,
            'berat_badan' => $this->weight,
            'tinggi_badan' => $this->height,
            'date_of_birth' => $this->dateOfBirth,
        ]);

        session()->flash('status', 'Data berhasil disimpan!');

        $this->redirectRoute('dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.bio');
    }
}

