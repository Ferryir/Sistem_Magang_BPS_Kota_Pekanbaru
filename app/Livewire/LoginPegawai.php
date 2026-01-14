<?php

namespace App\Livewire;

use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LoginPegawai extends Component
{
    #[Validate]
    public $email, $password, $remember;

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email' => [
                "required" => 'Email tidak boleh kosong',
                "email" => 'Gunakan email yang valid',
            ],
            'password' => [
                "required" => 'Password tidak boleh kosong',
            ],
        ];
    }

    public function login_pegawai()
    {
        $this->validate();

        $remember = !empty($this->remember) ? true : false;

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (!Pegawai::where('email', $this->email)->exists()) {

            return redirect('/login-pegawai')->with([
                'error' => [
                    "title" => "Email tidak terdaftar!",
                ]
            ]);
        }

        if (Auth::guard('pegawai')->attempt($credentials, $remember)) {
            return redirect()->intended('dashboard-admin')->with([
                'success' => [
                    "title" => "Berhasil masuk",
                ]
            ]);
        }

        return redirect('/login-pegawai')->with([
            'error' => [
                "title" => "Email atau password salah!",
            ]
        ]);
    }
}
