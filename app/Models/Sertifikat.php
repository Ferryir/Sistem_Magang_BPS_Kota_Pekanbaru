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
     * Generate nomor sertifikat otomatis
     * Format: B-MMDDXXX/14.710/HM.340/YYYY
     */
    public static function generateNomorSertifikat(): string
    {
        $now = now();
        $month = $now->format('m');
        $day = $now->format('d');
        $year = $now->format('Y');

        // Get count of certificates generated today
        $countToday = self::whereDate('tanggal_terbit', $now->toDateString())->count();
        $nextNumber = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

        return "B-{$month}{$day}{$nextNumber}/14.710/HM.340/{$year}";
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
