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
            // Akun Admin 1
            // ==============
            [
                "name" => "admin1",
                "fungsi_bagian" => "Bagian Umum",
                "email" => "admin@gmail.com",
                "password" => "jawejawe123",
                "nomor_induk" => "147107822341122",
                "role_temp" => "admin"
            ],

            // ==============
            // Akun Admin 2
            // ==============
            [
                "name" => "admin2",
                "fungsi_bagian" => "Fungsi IPDS",
                "email" => "pembimbingipds1@gmail.com",
                "password" => "jawejawe123",
                "nomor_induk" => "147107822341123",
                "role_temp" => "admin"
            ],

            // ==============
            // Akun Admin 3
            // ==============
            [
                "name" => "admin3",
                "fungsi_bagian" => "Fungsi IPDS",
                "email" => "pembimbingipds2@gmail.com",
                "password" => "jawejawe123",
                "nomor_induk" => "147107822341124",
                "role_temp" => "admin"
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
