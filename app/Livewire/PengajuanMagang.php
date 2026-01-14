<?php

namespace App\Livewire;

use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PengajuanMagang extends Component
{
    #[Validate]

    public $jenis_magang,
    $bidang_tujuan,
    $tanggal_mulai,
    $tanggal_selesai;

    public function mount()
    {
        $this->jenis_magang = '';
        $this->bidang_tujuan = '';
    }

    public function rules()
    {
        return [
            'jenis_magang' => 'required',
            'bidang_tujuan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required|after:tanggal_mulai'
        ];
    }

    public function messages()
    {
        return [
            'jenis_magang' => [
                "required" => 'Jenis magang tidak boleh kosong',
            ],
            'bidang_tujuan' => [
                "required" => 'Bidang tujuan tidak boleh kosong',
            ],
            'tanggal_mulai' => [
                "required" => 'Tanggal mulai magang tidak boleh kosong',
            ],
            'tanggal_selesai' => [
                "required" => 'Tanggal selesai magang tidak boleh kosong',
                "after" => 'Tanggal selesai magang harus setelah tanggal mulai'
            ],
        ];
    }

    public function create_pengajuan()
    {
        // Validasi data input
        $validatedData = $this->validate();

        // Mengambil data user yang sedang login
        $user = Auth::user();

        $pengajuan = new Pengajuan();
        $pengajuan->user_id = $user->id;
        $pengajuan->jenis_magang = $validatedData['jenis_magang'];
        $pengajuan->bidang_tujuan = $validatedData['bidang_tujuan'];
        $pengajuan->tanggal_mulai = $validatedData['tanggal_mulai'];
        $pengajuan->tanggal_selesai = $validatedData['tanggal_selesai'];

        //data akademik
        $pengajuan->institusi = $user->institusi;
        $pengajuan->jurusan = $user->jurusan;
        $pengajuan->nomor_induk = $user->nomor_induk;

        //data pribadi
        $pengajuan->foto_profil = $user->foto_profil;
        $pengajuan->name = $user->name;
        $pengajuan->email = $user->email;
        $pengajuan->nomor_hp = $user->nomor_hp;
        $pengajuan->tentang_saya = $user->tentang_saya;
        $pengajuan->jenis_kelamin = $user->jenis_kelamin;
        $pengajuan->tempat_lahir = $user->tempat_lahir;
        $pengajuan->tanggal_lahir = $user->tanggal_lahir;
        $pengajuan->alamat = $user->alamat;

        $pengajuan->kartu_penduduk = $user->kartu_penduduk;
        $pengajuan->original_filename_ktp = $user->original_filename_ktp;
        $pengajuan->kartu_tanda = $user->kartu_tanda;
        $pengajuan->original_filename_kartu = $user->original_filename_kartu;

        $pengajuan->save();

        $user->status_magang = 'masa-daftar';
        $user->save();

        return redirect('/dashboard')->with([
            'success' => [
                "title" => "Berhasil mengajukan magang",
                "message" => "Akun berhasil diperbarui"
            ]
        ]);
    }

}
