<?php

namespace App\Livewire;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ForgotPassword extends Component
{
    #[Validate]
    public $email;

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'email' => [
                "required" => 'Email tidak boleh kosong',
                "email" => 'Gunakan email yang valid',
            ],
        ];
    }

    public function forgot_password()
    {
        $this->validate();
        
        $count = User::where('email', '=', $this->email)->count();
        if ($count > 0) {
            $user = User::where('email', '=', $this->email)->first();
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect('/forgot-password')->with([
                'success' => [
                    "title" => "Cek kotak email kamu",
                ]
            ]);
        }
        else{
            return redirect('/forgot-password')->with([
                'error' => [
                    "title" => "Email tidak terdaftar!",
                ]
            ]);
        }
    }
}
