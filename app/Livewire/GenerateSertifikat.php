<?php

namespace App\Livewire;

use App\Models\PenilaianMagang;
use App\Models\Sertifikat;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GenerateSertifikat extends Component
{
    public $search = '';

    // Modal properties
    public $showModal = false;
    public $selectedUserId = null;
    public $nomorUrut = '';
    public $previewNomorSertifikat = '';

    // Untuk menampilkan preview nomor sertifikat
    public function updatedNomorUrut($value)
    {
        if (!empty($value) && is_numeric($value)) {
            $this->previewNomorSertifikat = Sertifikat::generateNomorSertifikat($value);
        } else {
            $this->previewNomorSertifikat = '';
        }
    }

    public function openGenerateModal($userId)
    {
        $this->selectedUserId = $userId;
        $this->nomorUrut = '';
        $this->previewNomorSertifikat = '';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedUserId = null;
        $this->nomorUrut = '';
        $this->previewNomorSertifikat = '';
        $this->resetErrorBag();
    }

    public function generateSertifikat()
    {
        // Validate nomor urut
        $this->validate([
            'nomorUrut' => 'required|numeric|min:1|max:999',
        ], [
            'nomorUrut.required' => 'Nomor urut wajib diisi',
            'nomorUrut.numeric' => 'Nomor urut harus berupa angka',
            'nomorUrut.min' => 'Nomor urut minimal 1',
            'nomorUrut.max' => 'Nomor urut maksimal 999',
        ]);

        $user = User::find($this->selectedUserId);

        if (!$user) {
            session()->flash('error', 'User tidak ditemukan');
            $this->closeModal();
            return;
        }

        // Get active pengajuan (accept-final or selesai)
        $pengajuan = $user->pengajuan()->whereIn('status_pengajuan', ['accept-final', 'selesai'])->first();

        if (!$pengajuan) {
            session()->flash('error', 'Pengajuan magang tidak ditemukan');
            $this->closeModal();
            return;
        }

        // Check if penilaian exists
        $penilaian = PenilaianMagang::where('user_id', $this->selectedUserId)->first();

        if (!$penilaian || $penilaian->nilai_akhir === null) {
            session()->flash('error', 'Penilaian magang belum selesai');
            $this->closeModal();
            return;
        }

        // Check if certificate already exists
        $existingSertifikat = Sertifikat::where('user_id', $this->selectedUserId)
            ->where('pengajuan_id', $pengajuan->id)
            ->first();

        if ($existingSertifikat) {
            session()->flash('error', 'Sertifikat sudah pernah digenerate');
            $this->closeModal();
            return;
        }

        // Generate certificate number with manual nomor urut
        $nomorSertifikat = Sertifikat::generateNomorSertifikat($this->nomorUrut);

        // Check if nomor sertifikat already exists
        if (Sertifikat::isNomorSertifikatExists($nomorSertifikat)) {
            $this->addError('nomorUrut', 'Nomor sertifikat "' . $nomorSertifikat . '" sudah digunakan. Silakan gunakan nomor urut lain.');
            return;
        }

        // Create certificate record
        $sertifikat = Sertifikat::create([
            'user_id' => $this->selectedUserId,
            'pengajuan_id' => $pengajuan->id,
            'nomor_sertifikat' => $nomorSertifikat,
            'tanggal_terbit' => now(),
            'generated_by' => Auth::guard('pegawai')->id(),
        ]);

        // Generate PDF
        $pdf = Pdf::loadView('pdf.sertifikat', [
            'user' => $user,
            'pengajuan' => $pengajuan,
            'sertifikat' => $sertifikat,
            'penilaian' => $penilaian,
        ])->setPaper('a4', 'landscape');

        // Save PDF
        $filename = 'sertifikat_' . str_replace(' ', '_', strtolower($user->name)) . '_' . $sertifikat->id . '.pdf';
        $path = 'sertifikat/' . $filename;

        // Ensure directory exists
        if (!file_exists(storage_path('app/public/sertifikat'))) {
            mkdir(storage_path('app/public/sertifikat'), 0755, true);
        }

        $pdf->save(storage_path('app/public/' . $path));

        // Update file path
        $sertifikat->update(['file_path' => $path]);

        // Update pengajuan status to 'selesai' (completed)
        $pengajuan->update(['status_pengajuan' => 'selesai']);

        $this->closeModal();
        session()->flash('success', 'Sertifikat berhasil digenerate untuk ' . $user->name . ' dengan nomor: ' . $nomorSertifikat);
    }

    public function downloadSertifikat($sertifikatId)
    {
        $sertifikat = Sertifikat::find($sertifikatId);

        if (!$sertifikat || !$sertifikat->file_path) {
            session()->flash('error', 'File sertifikat tidak ditemukan');
            return;
        }

        return response()->download(storage_path('app/public/' . $sertifikat->file_path));
    }

    public function render()
    {
        // Get all users with completed assessment (accept-final or selesai)
        $users = User::whereHas('pengajuan', function ($q) {
            $q->whereIn('status_pengajuan', ['accept-final', 'selesai']);
        })
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->with([
                'pengajuan' => function ($q) {
                    $q->whereIn('status_pengajuan', ['accept-final', 'selesai']);
                }
            ])
            ->get()
            ->map(function ($user) {
                $user->penilaian = PenilaianMagang::where('user_id', $user->id)->first();
                $user->sertifikat = Sertifikat::where('user_id', $user->id)->first();
                return $user;
            });

        return view('livewire.generate-sertifikat', [
            'users' => $users
        ]);
    }
}
