<?php

namespace App\Livewire;

use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class ShowPengajuan extends Component
{
    use WithPagination;

    public $search = "";

    public function updating($key): void
    {
        if ($key === 'search') {
            $this->resetPage();
        }
    }

    public function render()
    {
        // Build the base query
        $query = Pengajuan::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Apply search filter if search term is provided
        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('jenis_magang', 'like', '%' . $this->search . '%')
                    ->orWhere('bidang_tujuan', 'like', '%' . $this->search . '%');
            });
        }

        // Paginate the results
        $pengajuan = $query->paginate(5);

        return view('livewire.show-pengajuan', [
            'pengajuan' => $pengajuan
        ]);
    }
    
}
