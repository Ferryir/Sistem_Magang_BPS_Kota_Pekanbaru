<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class UserNormalController
{
    public function get_dashboard()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('usernormal.dashboard');
    }

    public function get_status_pengajuan()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('usernormal.pengajuan');
    }

    public function get_logbook()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('usernormal.pengisian-logbook');
    }

    public function get_upload_surat_pengantar_page()
    {
        if (request()->pjax()) {
            return false;
        }
        $user = Auth::user();

        $pengajuan = Pengajuan::where('user_id', $user->id)
            ->where('status_pengajuan', 'accept-first')
            ->where('surat_pengantar', null)
            ->first();

        if (!$pengajuan) {
            return redirect('/dashboard')->withErrors([
                'error' => "Pengajuan not found or is not in 'accept-first' status."
            ]);
        }

        return view('usernormal.surat-pengantar');
    }

    public function get_pengajuan_saya($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);

        if ($pengajuan == null) {
            abort(404);
        }

        return view('usernormal.pengajuan-saya', compact('pengajuan'));
    }

    public function delete_pengajuan($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);
        $user = Auth::user();

        if ($pengajuan == null) {
            abort(404);
        }

        $pengajuan->delete();

        $user->status_magang = 'tidak-aktif';
        $user->save();

        return redirect(url('/pengajuan'))->with([
            'success' => [
                "title" => "Pengajuan berhasil dihapus",
            ]
        ]);
    }

    public function pengajuan_ulang($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);
        $user = Auth::user();

        if ($pengajuan == null) {
            abort(404);
        }

        $pengajuan->status_pengajuan = "reject-final";
        $pengajuan->save();

        $user->status_magang = 'tidak-aktif';
        $user->save();

        return redirect(url('/dashboard'))->with([
            'success' => [
                "title" => "Silahkan ajukan magang kembali",
            ]
        ]);
    }
}
