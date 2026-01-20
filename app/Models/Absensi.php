<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'pengajuan_id',
        'tanggal',
        'status',
        'uraian_aktivitas',
        'pembelajaran_diperoleh',
        'kendala_dialami',
        'verifikasi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'verifikasi' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($absensi) {
            $absensi->id = Str::uuid();
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
}
