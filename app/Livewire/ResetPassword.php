<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ResetPassword extends Component
{
    #[Validate]

    public $password,
    $confirm_password,
    $token;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function rules()
    {
        return [
            'password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'confirm_password' => 'required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            'password' => [
                "required" => 'Password tidak boleh kosong',
                "min" => 'Password minimal 8 karakter',
                "regex" => 'Password harus mengandung huruf dan angka'
            ],
            'confirm_password' => [
                "required_with" => 'Konfirmasi password tidak boleh kosong jika password diisi',
                "same" => 'Password tidak sama'
            ]
        ];
    }

    public function reset_password()
    {
        $this->validate();
        
        $user = User::where('remember_token', $this->token);
        if ($user->count() == 0) {
            abort(403);
        }
        $user = $user->first();

        $user->password = Hash::make($this->password);
        $user->remember_token = Str::random(50);
        $user->save();

        return redirect('/login')->with([
            'success' => [
                "title" => "Password berhasil diperbarui",
            ]
        ]);
    }
}
