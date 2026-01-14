<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function get_login_page(){
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        if (!empty(Auth::guard('pegawai')->check())) {
            return redirect('dashboard-admin');
        }
        return view('auth.login');
    }

    public function get_login_pegawai_page(){
        if (!empty(Auth::guard('pegawai')->check())) {
            return redirect('dashboard-admin');
        }
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        return view('auth.login_pegawai');
    }

    public function get_registrasi_page(){
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        return view('auth.registrasi');
    }

    public function get_forgot_password_page(){
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        return view('auth.forgotPassword');
    }

    public function get_reset_password_page(Request $request, $token){
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }

        $user = User::where('remember_token', '=', $token);
        if ($user->count() == 0) {
            abort(403);
        }
        $user = $user->first();
        $data['token'] = $token;

        return view('auth.resetPassword', $data);
    }

    public function logout()
    {
        if (Auth::guard('pegawai')->check()) {
            Auth::guard('pegawai')->logout();
            return redirect(url('/'))->with([
                'success' => [
                    "title" => "Berhasil keluar",
                ]
            ]);
        }

        if (Auth::check()) {
            Auth::logout();
            return redirect(url('/'))->with([
                'success' => [
                    "title" => "Berhasil keluar",
                ]
            ]);
        }
    }
}
