<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';
    protected $primary = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'jenis_magang',
        'bidang_tujuan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_pengajuan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengajuan) {
            $pengajuan->id = Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
