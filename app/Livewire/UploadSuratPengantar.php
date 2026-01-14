<?php

namespace App\Livewire;

use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadSuratPengantar extends Component
{
    use WithFileUploads;

    #[Validate]
    public $surat_pengantar;

    public function rules()
    {
        return [
            'surat_pengantar' => 'max:2048'
        ];
    }

    public function messages()
    {
        return [
            'surat_pengantar' => [
                "max" => 'File tidak boleh lebih dari 2mb'
            ]
        ];
    }

    public function upload_surat_pengantar()
    {
        $this->validate();

        $originalFileName = $this->surat_pengantar->getClientOriginalName();
        $imagePath = $this->surat_pengantar->store('surat-pengantar', 'public');

        // $pengajuan = Auth::user()->pengajuan()->where('status_pengajuan', 'accept-first')->first();

        $user = Auth::user();
        $pengajuan = Pengajuan::where('user_id', $user->id)
                                ->where('status_pengajuan', 'accept-first')
                                ->first();
        $pengajuan->surat_pengantar = $imagePath;
        $pengajuan->original_filename_surat_pengantar = $originalFileName;
        $pengajuan->tenggat = null;
        $pengajuan->save();

        return redirect(to: '/dashboard')->with([
            'success' => [
                "title" => "Surat pengantar berhasil diupload"
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.upload-surat-pengantar');
    }
}
