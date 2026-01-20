<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenilaianMagang extends Model
{
    protected $table = 'penilaian_magang';

    protected $fillable = [
        'user_id',
        'pengajuan_id',
        'sikap_etika',
        'kemampuan_teknis',
        'kemauan_belajar',
        'kualitas_kerja',
        'komunikasi_kerjasama',
        'nilai_akhir',
        'catatan',
        'penilai_id',
    ];

    protected $casts = [
        'nilai_akhir' => 'decimal:2',
    ];

    // Auto calculate nilai_akhir before saving
    protected static function booted()
    {
        static::saving(function ($penilaian) {
            if (
                $penilaian->sikap_etika !== null &&
                $penilaian->kemampuan_teknis !== null &&
                $penilaian->kemauan_belajar !== null &&
                $penilaian->kualitas_kerja !== null &&
                $penilaian->komunikasi_kerjasama !== null
            ) {

                $total = $penilaian->sikap_etika +
                    $penilaian->kemampuan_teknis +
                    $penilaian->kemauan_belajar +
                    $penilaian->kualitas_kerja +
                    $penilaian->komunikasi_kerjasama;

                $penilaian->nilai_akhir = $total / 5;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function penilai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'penilai_id');
    }
}
