<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RolePegawai extends Model
{
    use HasFactory;

    protected $table = 'role_pegawai';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rolePegawai) {
            $rolePegawai->id = Str::uuid();
        });
    }

    // Define the relationship
    public function pegawai()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_role', 'role_pegawai_id', 'pegawai_id');
    }
}

