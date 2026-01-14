<?php

namespace App\Http\Controllers;

use App\Jobs\UpdatePengajuanStatusJob;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class AdminController
{
    public function get_dashboard_admin()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.dashboard');
    }

    public function get_daftar_pengajuan()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.daftar-pengajuan');
    }

    public function get_review_logbook()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.review-logbook');
    }

    public function get_detail_pengajuan($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);

        if ($pengajuan == null) {
            abort(404);
        }

        return view('admin.detail-pengajuan', compact('pengajuan'));
    }

    public function terima_pengajuan($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);
        
        if ($pengajuan == null) {
            abort(404);
        }
        
        $pengajuan->status_pengajuan = "accept-first";
        // Set tenggat to 7 days 
        // $pengajuan->tenggat = now()->addDays(7);
        // Set tenggat to 1 minute 
        $pengajuan->tenggat = now()->addMinutes(1);
        $pengajuan->save();

        // Dispatch job untuk memperbarui status setelah tenggat
        // Set tenggat to 7 days 
        // UpdatePengajuanStatusJob::dispatch($pengajuan)->delay(now()->addDays(7));
        // Set tenggat to 1 minute 
        UpdatePengajuanStatusJob::dispatch($pengajuan)->delay(now()->addMinutes(1));

        return redirect(url('/daftar-pengajuan'))->with([
            'success' => [
                "title" => "Berhasil menerima pengajuan",
            ]
        ]);
    }

    public function tolak_pengajuan($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);
        
        if ($pengajuan == null) {
            abort(404);
        }
        
        $pengajuan->status_pengajuan = "reject-admin";
        $komentar = request('komentar');
        $pengajuan->komentar = $komentar;
        $pengajuan->save();

        return redirect(url('/daftar-pengajuan'))->with([
            'success' => [
                "title" => "Berhasil menolak pengajuan",
            ]
        ]);
    }
}
