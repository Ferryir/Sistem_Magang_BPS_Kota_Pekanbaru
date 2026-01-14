<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Registrasi extends Component
{
    use WithFileUploads;

    #[Validate]
    public $name,
    $email,
    $nomor_induk,
    $institusi,
    $jurusan,
    $nomor_hp,
    $kartu_tanda,
    $password,
    $confirm_password;

    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'nomor_induk' => 'required|min:5|unique:users',
            'institusi' => 'required',
            'jurusan' => 'required',
            'kartu_tanda' => 'required|max:2048',
            'nomor_hp' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'confirm_password' => 'required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            'name' => [
                "required" => 'Nama tidak boleh kosong',
                "min" => 'Nama minimal 5 karakter',
            ],
            'email' => [
                "required" => 'Email tidak boleh kosong',
                "email" => 'Gunakan email yang valid',
                "unique" => 'Email ini sudah terdaftar',
            ],
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
            ],
            'kartu_tanda' => [
                "required" => 'Kartu tanda siswa/mahasiswa tidak boleh kosong',
                "max" => 'File tidak boleh lebih dari 2mb'
            ],
            'nomor_hp' => [
                "required" => 'Nomor HP tidak boleh kosong',
            ],
            'password' => [
                "required" => 'Password tidak boleh kosong',
                "min" => 'Password minimal 8 karakter',
                "regex" => 'Password harus mengandung huruf dan angka'
            ],
            'confirm_password' => [
                "required_with" => 'Konfirmasi password tidak boleh kosong jika password diisi',
                "same" => 'Password tidak sama'
            ]
        ];
    }

    public function create_user()
    {
        // Validasi data input
        $validatedData = $this->validate();

        // Mendapatkan nama asli file
        $originalFilename = $this->kartu_tanda->getClientOriginalName();

        // Menyimpan gambar ke penyimpanan publik
        $imagePath = $this->kartu_tanda->store('kartu_tanda', 'public', );

        // Membuat instance user baru dan mengisi properti dengan data yang divalidasi
        $user = new User();
        $user->name = ucwords(strtolower(trim($validatedData['name'])));
        $user->email = $validatedData['email'];
        $user->nomor_induk = $validatedData['nomor_induk'];
        $user->institusi = ucwords(strtolower(trim($validatedData['institusi'])));
        $user->jurusan = ucwords(strtolower(trim($validatedData['jurusan'])));
        $user->kartu_tanda = $imagePath;
        $user->original_filename_kartu = $originalFilename;
        $user->nomor_hp = $validatedData['nomor_hp'];
        $user->password = Hash::make($validatedData['password']);
        $user->remember_token = Str::uuid()->toString();

        // Menyimpan user ke database
        $user->save();

        // Mengarahkan pengguna kembali ke halaman registrasi dengan pesan sukses
        return redirect('/login')->with([
            'success' => [
                "title" => "Registrasi Berhasil!",
                "message" => "Akun berhasil didaftarkan, silahkan masuk"
            ]
        ]);
    }
}
