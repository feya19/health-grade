<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\AiAssistant;
use Illuminate\Support\Facades\Auth;

#[Title('Profile')]
class Profile extends Component
{
    public function render()
    {
        return view('livewire.profile');
    }
}