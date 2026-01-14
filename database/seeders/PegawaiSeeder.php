<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawai = [

            // ==============
            // Akun Admin
            // ==============
            [
                "name" => "Lionel Messi",
                "fungsi_bagian" => "Bagian Umum",
                "email" => "admin@gmail.com",
                "password" => "admin123",
                "nomor_induk" => "147107822341122",
                "role_temp" => "admin"
            ],

            // ================
            // Akun Pembimbing
            // ================
            [
                "name" => "Kylian Mbappe",
                "fungsi_bagian" => "Fungsi IPDS",
                "email" => "pembimbingipds1@gmail.com",
                "password" => "regular123",
                "nomor_induk" => "147107822341123",
                "role_temp" => "regular"
            ],
            [
                "name" => "Son Hyung Min",
                "fungsi_bagian" => "Fungsi IPDS",
                "email" => "pembimbingipds2@gmail.com",
                "password" => "regular123",
                "nomor_induk" => "147107822341124",
                "role_temp" => "regular"
            ],
        ];

        foreach ($pegawai as $data) {
            Pegawai::create([
                "name" => $data['name'],
                "fungsi_bagian" => $data['fungsi_bagian'],
                "email" => $data['email'],
                "password" => $data['password'],
                "nomor_induk" => $data['nomor_induk'],
                "role_temp" => $data['role_temp'],
                "remember_token" => Str::random(50),
            ]);

            // Pegawai::create($data);
        }
    }
}
