<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    protected $fillable = [
        'user_id',
        'pengajuan_id',
        'nomor_sertifikat',
        'tanggal_terbit',
        'file_path',
        'generated_by',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    /**
     * Generate nomor sertifikat dengan nomor urut manual
     * Format: B-MMDDXXX/14.710/HM.340/YYYY
     * @param string $nomorUrut - Nomor urut 3 digit (contoh: 001, 002, dst)
     */
    public static function generateNomorSertifikat(string $nomorUrut): string
    {
        $now = now();
        $month = $now->format('m');
        $day = $now->format('d');
        $year = $now->format('Y');

        // Pastikan nomor urut 3 digit dengan padding 0
        $nomorUrut = str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

        return "B-{$month}{$day}{$nomorUrut}/14.710/HM.340/{$year}";
    }

    /**
     * Cek apakah nomor sertifikat sudah ada di database
     * @param string $nomorSertifikat
     * @return bool
     */
    public static function isNomorSertifikatExists(string $nomorSertifikat): bool
    {
        return self::where('nomor_sertifikat', $nomorSertifikat)->exists();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'generated_by');
    }
}
