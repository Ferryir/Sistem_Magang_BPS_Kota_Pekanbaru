<?php

namespace App\Livewire;

use App\Models\PenilaianMagang;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PenilaianMagangForm extends Component
{
    public $selectedUserId;
    public $sikap_etika;
    public $kemampuan_teknis;
    public $kemauan_belajar;
    public $kualitas_kerja;
    public $komunikasi_kerjasama;
    public $catatan;
    public $nilai_akhir = 0;

    public function rules()
    {
        return [
            'selectedUserId' => 'required',
            'sikap_etika' => 'required|integer|min:0|max:100',
            'kemampuan_teknis' => 'required|integer|min:0|max:100',
            'kemauan_belajar' => 'required|integer|min:0|max:100',
            'kualitas_kerja' => 'required|integer|min:0|max:100',
            'komunikasi_kerjasama' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'selectedUserId.required' => 'Pilih peserta magang terlebih dahulu',
            'sikap_etika.required' => 'Nilai sikap dan etika kerja wajib diisi',
            'sikap_etika.min' => 'Nilai minimal 0',
            'sikap_etika.max' => 'Nilai maksimal 100',
            'kemampuan_teknis.required' => 'Nilai kemampuan teknis wajib diisi',
            'kemampuan_teknis.min' => 'Nilai minimal 0',
            'kemampuan_teknis.max' => 'Nilai maksimal 100',
            'kemauan_belajar.required' => 'Nilai kemauan belajar wajib diisi',
            'kemauan_belajar.min' => 'Nilai minimal 0',
            'kemauan_belajar.max' => 'Nilai maksimal 100',
            'kualitas_kerja.required' => 'Nilai kualitas kerja wajib diisi',
            'kualitas_kerja.min' => 'Nilai minimal 0',
            'kualitas_kerja.max' => 'Nilai maksimal 100',
            'komunikasi_kerjasama.required' => 'Nilai komunikasi wajib diisi',
            'komunikasi_kerjasama.min' => 'Nilai minimal 0',
            'komunikasi_kerjasama.max' => 'Nilai maksimal 100',
        ];
    }

    public function updated($propertyName)
    {
        // Auto calculate nilai_akhir when any score is updated
        if (in_array($propertyName, ['sikap_etika', 'kemampuan_teknis', 'kemauan_belajar', 'kualitas_kerja', 'komunikasi_kerjasama'])) {
            $this->calculateNilaiAkhir();
        }
    }

    public function calculateNilaiAkhir()
    {
        $values = [
            $this->sikap_etika,
            $this->kemampuan_teknis,
            $this->kemauan_belajar,
            $this->kualitas_kerja,
            $this->komunikasi_kerjasama
        ];

        // Only calculate if all values are filled
        if (!in_array(null, $values) && !in_array('', $values)) {
            $total = array_sum($values);
            $this->nilai_akhir = number_format($total / 5, 2);
        } else {
            $this->nilai_akhir = 0;
        }
    }

    public function loadPenilaian()
    {
        if ($this->selectedUserId) {
            $user = User::find($this->selectedUserId);
            $pengajuan = $user->pengajuan()->where('status_pengajuan', 'accept-final')->first();

            if ($pengajuan) {
                $penilaian = PenilaianMagang::where('user_id', $this->selectedUserId)
                    ->where('pengajuan_id', $pengajuan->id)
                    ->first();

                if ($penilaian) {
                    $this->sikap_etika = $penilaian->sikap_etika;
                    $this->kemampuan_teknis = $penilaian->kemampuan_teknis;
                    $this->kemauan_belajar = $penilaian->kemauan_belajar;
                    $this->kualitas_kerja = $penilaian->kualitas_kerja;
                    $this->komunikasi_kerjasama = $penilaian->komunikasi_kerjasama;
                    $this->catatan = $penilaian->catatan;
                    $this->calculateNilaiAkhir();
                } else {
                    $this->reset(['sikap_etika', 'kemampuan_teknis', 'kemauan_belajar', 'kualitas_kerja', 'komunikasi_kerjasama', 'catatan', 'nilai_akhir']);
                }
            }
        }
    }

    public function simpanPenilaian()
    {
        $this->validate();

        $user = User::find($this->selectedUserId);
        $pengajuan = $user->pengajuan()->where('status_pengajuan', 'accept-final')->first();

        if (!$pengajuan) {
            session()->flash('error', 'Pengajuan tidak ditemukan');
            return;
        }

        PenilaianMagang::updateOrCreate(
            [
                'user_id' => $this->selectedUserId,
                'pengajuan_id' => $pengajuan->id
            ],
            [
                'sikap_etika' => $this->sikap_etika,
                'kemampuan_teknis' => $this->kemampuan_teknis,
                'kemauan_belajar' => $this->kemauan_belajar,
                'kualitas_kerja' => $this->kualitas_kerja,
                'komunikasi_kerjasama' => $this->komunikasi_kerjasama,
                'catatan' => $this->catatan,
                'penilai_id' => Auth::guard('pegawai')->id(),
            ]
        );

        session()->flash('success', 'Penilaian berhasil disimpan');
        $this->reset(['selectedUserId', 'sikap_etika', 'kemampuan_teknis', 'kemauan_belajar', 'kualitas_kerja', 'komunikasi_kerjasama', 'catatan', 'nilai_akhir']);
    }

    public function render()
    {
        // Get all active interns (accept-final status)
        $activeInterns = User::whereHas('pengajuan', function ($q) {
            $q->where('status_pengajuan', 'accept-final');
        })->with([
                    'pengajuan' => function ($q) {
                        $q->where('status_pengajuan', 'accept-final')->latest();
                    }
                ])->get();

        return view('livewire.penilaian-magang-form', [
            'activeInterns' => $activeInterns
        ]);
    }
}
