<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController
{
    public function index() {
        $fungsi_bagian = [
            [
                'title' => 'Statistik Sosial',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Hukum', 'Teknik Elektro', 'Statistika','Teknik Informatika', 'Hukum', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Statistik Produksi',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Statistik Distribusi',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Fungsi Nerwilis',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Fungsi IPDS',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Bagian Umum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ]
        ];

        $faqs = [
            [
                'question' => 'Berapa lama magang di BPS Provinsi Riau?',
                'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda voluptatem vitae, repudiandae sunt dolorem reprehenderit distinctio est unde sequi rem soluta quis perspiciatis laborum eum. Eaque aliquid dolores saepe repellendus!',
            ],
            [
                'question' => 'Bisakah untuk konversi mata kuliah?',
                'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda voluptatem vitae, repudiandae sunt dolorem reprehenderit distinctio est unde sequi rem soluta quis perspiciatis laborum eum. Eaque aliquid dolores saepe repellendus!',
            ],
            [
                'question' => 'Apakah magang ini paid atau unpaid?',
                'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda voluptatem vitae, repudiandae sunt dolorem reprehenderit distinctio est unde sequi rem soluta quis perspiciatis laborum eum. Eaque aliquid dolores saepe repellendus!',
            ],
            [
                'question' => 'Apakah penempatan ditentukan langsung oleh BPS?',
                'answer' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda voluptatem vitae, repudiandae sunt dolorem reprehenderit distinctio est unde sequi rem soluta quis perspiciatis laborum eum. Eaque aliquid dolores saepe repellendus!',
            ],
        ];

        return view('home', compact('fungsi_bagian', 'faqs'));
    }

    public function get_user_profil()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('public.profil');
    }

    public function get_user_profil_edit()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('public.profil-edit');
    }

    public function get_ubah_password()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('public.ubah-password');
    }
}
