<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\ScanHistory;
use Illuminate\Support\Facades\Auth;

#[Title('Riwayat Scan - HealthGrade')]
class History extends Component
{
    use WithPagination;

    public $search = '';
    public $filterGrade = 'all';

    // Reset pagination saat search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Query Database
        $history = ScanHistory::query()
            ->with('food') // Eager load relasi food
            ->where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                // Search berdasarkan nama makanan di tabel foods
                $query->whereHas('food', function ($q) {
                    $q->where('name', 'ilike', '%' . $this->search . '%') // ilike = case insensitive (Postgres)
                      ->orWhere('brand', 'ilike', '%' . $this->search . '%');
                });
            })
            ->when($this->filterGrade !== 'all', function ($query) {
                // Filter berdasarkan grade di tabel foods
                $query->whereHas('food', function ($q) {
                    $q->where('grade', $this->filterGrade);
                });
            })
            ->latest() // Order by created_at desc
            ->paginate(10);

        return view('livewire.history', [
            'history' => $history
        ]);
    }
}