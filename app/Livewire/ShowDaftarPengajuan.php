<?php

namespace App\Livewire;

use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDaftarPengajuan extends Component
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
        $query = Pengajuan::orderBy('created_at', 'desc')
            ->where('status_pengajuan', 'waiting')
            ->orWhere('status_pengajuan', 'accept-first');

        // Apply search filter if search term is provided
        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('jenis_magang', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('institusi', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Paginate the results
        $pengajuan = $query->paginate(5);

        return view('livewire.show-daftar-pengajuan', [
            'pengajuan' => $pengajuan
        ]);
    }

}
