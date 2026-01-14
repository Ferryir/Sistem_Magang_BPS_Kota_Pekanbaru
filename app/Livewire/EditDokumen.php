<?php

namespace App\Livewire;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditDokumen extends Component
{
    use WithFileUploads;

    #[Validate]
    public $kartu_penduduk,
    $kartu_tanda;

    public function rules()
    {
        return [
            'kartu_penduduk' => 'max:2048',
            'kartu_tanda' => 'max:2048'
        ];
    }

    public function messages()
    {
        return [
            'kartu_penduduk' => [
                "max" => 'File tidak boleh lebih dari 2mb'
            ],
            'kartu_tanda' => [
                "max" => 'File tidak boleh lebih dari 2mb'
            ]
        ];
    }

    public function update_dokumen()
    {
        // Validasi data input
        $this->validate();

        // Cek jika jika merubah dokumen
        $user = Auth::user();
        $ktp = $user->kartu_penduduk;
        $ktsm = $user->kartu_tanda;

        $isNewKtp = false;
        $isNewKtsm = false;

        $originalFilenameKtp = $user->original_filename_ktp;
        $originalFilenameKtsm = $user->original_filename_kartu;

        if ($this->kartu_penduduk instanceof UploadedFile) {
            // Simpan dokumen yang baru dan dapatkan path-nya
            $ktp = $this->kartu_penduduk->store('kartu_penduduk', 'public');
            $originalFilenameKtp = $this->kartu_penduduk->getClientOriginalName();
            $isNewKtp = true;
        }

        if ($this->kartu_tanda instanceof UploadedFile) {
            // Simpan dokumen yang baru dan dapatkan path-nya
            $ktsm = $this->kartu_tanda->store('kartu_tanda', 'public');
            $originalFilenameKtsm = $this->kartu_tanda->getClientOriginalName();
            $isNewKtsm = true;
        }

        // Cekk jika data tidak berubah
        $isDataChanged = $isNewKtp || $isNewKtsm;

        if (!$isDataChanged) {
            return redirect('/profil-edit?selected=dokumen')->with([
                'warning' => [
                    "title" => "Tidak ada perubahan dokumen",
                    "message" => "Akun berhasil diperbarui"
                ]
            ]);
        }

        // Update user data with validated data
        $user->kartu_penduduk = $ktp;
        $user->original_filename_ktp = $originalFilenameKtp;
        $user->kartu_tanda = $ktsm;
        $user->original_filename_kartu = $originalFilenameKtsm;
        $user->save();

        return redirect('/profil')->with([
            'success' => [
                "title" => "Dokumen Berhasil diperbarui",
                "message" => "Akun berhasil diperbarui"
            ]
        ]);
    }
}
