<?php

namespace App\Livewire;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditBiodata extends Component
{
    use WithFileUploads;

    #[Validate]

    public $name,
    $foto_profil,
    $tentang_saya,
    $jenis_kelamin,
    $tempat_lahir,
    $tanggal_lahir,
    $nomor_hp,
    $alamat;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->foto_profil = $user->foto_profil;
        $this->tentang_saya = $user->tentang_saya;
        $this->jenis_kelamin = $user->jenis_kelamin ?? '';
        $this->tempat_lahir = $user->tempat_lahir;
        $this->tanggal_lahir = $user->tanggal_lahir;
        $this->nomor_hp = $user->nomor_hp;
        $this->alamat = $user->alamat;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'foto_profil' => 'max:2048',
            'tentang_saya' => 'required|max:250',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_hp' => 'required',
            'alamat' => 'required|max:250',
        ];
    }

    public function messages()
    {
        return [
            'name' => [
                "required" => 'Nama tidak boleh kosong',
                "min" => 'Nama minimal 5 karakter',
            ],
            'foto_profil' => [
                "max" => 'File tidak boleh lebih dari 2mb'
            ],
            'tentang_saya' => [
                "required" => 'Tentang saya tidak boleh kosong',
                "max" => 'Maksimal 250 karakter'
            ],
            'jenis_kelamin' => [
                "required" => 'Jenis Kelamin tidak boleh kosong',
            ],
            'tempat_lahir' => [
                "required" => 'Tempat Lahir tidak boleh kosong',
            ],
            'tanggal_lahir' => [
                "required" => 'Tanggal Lahir tidak boleh kosong',
            ],
            'nomor_hp' => [
                "required" => 'Nomor HP tidak boleh kosong',
            ],
            'alamat' => [
                "required" => 'Alamat tidak boleh kosong',
                "max" => 'Maksimal 250 karakter'
            ],
        ];
    }

    public function update_data()
    {
        // Validasi data input
        $validatedData = $this->validate();

        // Cek jika jika merubah foto
        $user = Auth::user();
        $fotoProfil = $user->foto_profil;

        $isNewPhoto = false;
        if ($this->foto_profil instanceof UploadedFile) {
            // Simpan foto profil yang baru dan dapatkan path-nya
            $fotoProfil = $this->foto_profil->store('foto_profil', 'public');
            $isNewPhoto = true;
        }

        // Cekk jika data tidak berubah
        $isDataChanged =
            $user->name !== ucwords(strtolower(trim($validatedData['name']))) ||
            $user->tentang_saya !== $validatedData['tentang_saya'] ||
            $user->jenis_kelamin !== $validatedData['jenis_kelamin'] ||
            $user->tempat_lahir !== $validatedData['tempat_lahir'] ||
            $user->tanggal_lahir !== $validatedData['tanggal_lahir'] ||
            $user->nomor_hp !== $validatedData['nomor_hp'] ||
            $user->alamat !== $validatedData['alamat'] ||
            $isNewPhoto;

        if (!$isDataChanged) {
            return redirect('/profil-edit?selected=biodata')->with([
                'warning' => [
                    "title" => "Tidak ada perubahan data",
                    "message" => "Akun berhasil diperbarui"
                ]
            ]);
        }

        // Update user data with validated data
        $user->name = ucwords(strtolower(trim($validatedData['name'])));
        $user->foto_profil = $fotoProfil;
        $user->tentang_saya = $validatedData['tentang_saya'];
        $user->jenis_kelamin = $validatedData['jenis_kelamin'];
        $user->tempat_lahir = $validatedData['tempat_lahir'];
        $user->tanggal_lahir = $validatedData['tanggal_lahir'];
        $user->nomor_hp = $validatedData['nomor_hp'];
        $user->alamat = $validatedData['alamat'];
        $user->save();

        return redirect('/profil')->with([
            'success' => [
                "title" => "Data Berhasil diperbarui",
                "message" => "Akun berhasil diperbarui"
            ]
        ]);
    }
}
