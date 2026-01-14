<?php

namespace Database\Seeders;

use App\Models\RolePegawai;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            ["name" => "pembimbing"],
            ["name" => "admin"],
        ];

        foreach($role as $data){
            RolePegawai::create($data);
        }
    }
}
