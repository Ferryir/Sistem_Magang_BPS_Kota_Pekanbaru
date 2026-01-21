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

    public function generateSertifikat($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            session()->flash('error', 'User tidak ditemukan');
            return;
        }

        // Get active pengajuan
        $pengajuan = $user->pengajuan()->where('status_pengajuan', 'accept-final')->first();

        if (!$pengajuan) {
            session()->flash('error', 'Pengajuan magang tidak ditemukan');
            return;
        }

        // Check if penilaian exists
        $penilaian = PenilaianMagang::where('user_id', $userId)->first();

        if (!$penilaian || $penilaian->nilai_akhir === null) {
            session()->flash('error', 'Penilaian magang belum selesai');
            return;
        }

        // Check if certificate already exists
        $existingSertifikat = Sertifikat::where('user_id', $userId)
            ->where('pengajuan_id', $pengajuan->id)
            ->first();

        if ($existingSertifikat) {
            session()->flash('error', 'Sertifikat sudah pernah digenerate');
            return;
        }

        // Generate certificate number
        $nomorSertifikat = Sertifikat::generateNomorSertifikat();

        // Create certificate record
        $sertifikat = Sertifikat::create([
            'user_id' => $userId,
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

        session()->flash('success', 'Sertifikat berhasil digenerate untuk ' . $user->name);
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
