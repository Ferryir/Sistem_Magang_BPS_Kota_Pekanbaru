<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditAkademik extends Component
{
    #[Validate]

    public $nomor_induk,
    $institusi,
    $jurusan;

    public function mount()
    {
        $user = Auth::user();
        $this->institusi = $user->institusi;
        $this->jurusan = $user->jurusan;
        $this->nomor_induk = $user->nomor_induk;
    }

    public function rules()
    {
        return [
            'nomor_induk' => 'required|min:5|unique:users,nomor_induk,' . Auth::id(),
            'institusi' => 'required',
            'jurusan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nomor_induk' => [
                "required" => 'Nomor induk tidak boleh kosong',
                "min" => 'Nomor induk minimal 5 karakter',
                "unique" => 'Nomor induk ini sudah terdaftar',
            ],
            'institusi' => [
                "required" => 'Institusi tidak boleh kosong',
            ],
            'jurusan' => [
                "required" => 'Jurusan tidak boleh kosong',
            ]
        ];
    }

    public function update_akademik()
    {
        $user = Auth::user();

        // Cek jika data tidak berubah
        $isDataChanged =
            $user->institusi !== ucwords(strtolower(trim($this->institusi))) ||
            $user->jurusan !== ucwords(strtolower(trim($this->jurusan))) ||
            $user->nomor_induk !== $this->nomor_induk;

        if (!$isDataChanged) {
            return redirect('/profil-edit?selected=akademik')->with([
                'warning' => [
                    "title" => "Tidak ada perubahan data",
                    "message" => "Akun berhasil diperbarui"
                ]
            ]);
        }

        // Build dynamic validation rules
        $rules = [
            'institusi' => 'required',
            'jurusan' => 'required',
        ];

        // Add unique rule for nomor_induk if it has changed
        if ($user->nomor_induk !== $this->nomor_induk) {
            $rules['nomor_induk'] = 'required|min:5|unique:users,nomor_induk';
        } else {
            $rules['nomor_induk'] = 'required|min:5';
        }

        // Validate data input
        $validatedData = $this->validate($rules);

        // Update user data with validated data
        $user->institusi = ucwords(strtolower(trim($validatedData['institusi'])));
        $user->jurusan = ucwords(strtolower(trim($validatedData['jurusan'])));
        $user->nomor_induk = $validatedData['nomor_induk'];
        $user->save();

        return redirect('/profil')->with([
            'success' => [
                "title" => "Data Berhasil diperbarui",
                "message" => "Akun berhasil diperbarui"
            ]
        ]);
    }
}
