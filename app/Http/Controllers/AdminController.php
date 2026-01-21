<?php

namespace App\Http\Controllers;

use App\Jobs\UpdatePengajuanStatusJob;
use App\Models\Absensi;
use App\Models\Pengajuan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController
{
    public function get_dashboard_admin()
    {
        if (request()->pjax()) {
            return false;
        }

        // Get pengajuan statistics by status
        $pengajuanStats = [
            'pending' => Pengajuan::where('status_pengajuan', 'pending')->count(),
            'accept_first' => Pengajuan::where('status_pengajuan', 'accept-first')->count(),
            'accept_final' => Pengajuan::where('status_pengajuan', 'accept-final')->count(),
            'reject_admin' => Pengajuan::where('status_pengajuan', 'reject-admin')->count(),
            'reject_final' => Pengajuan::where('status_pengajuan', 'reject-final')->count(),
            'expired' => Pengajuan::where('status_pengajuan', 'reject-time')->count(),
            'total' => Pengajuan::whereNotIn('status_pengajuan', ['accept-first', 'accept-final', 'selesai', 'reject-admin', 'reject-final', 'reject-time'])->count(),
        ];

        // Get today's date
        $today = Carbon::today();

        // Get active interns (with accept-final status)
        $activeInterns = User::whereHas('pengajuan', function ($q) {
            $q->where('status_pengajuan', 'accept-final');
        })->with([
                    'pengajuan' => function ($q) {
                        $q->where('status_pengajuan', 'accept-final')->latest();
                    }
                ])->get();

        // Get today's attendance for each intern
        $todayAttendance = [];
        foreach ($activeInterns as $intern) {
            $pengajuan = $intern->pengajuan->first();
            $absensi = Absensi::where('user_id', $intern->id)
                ->whereDate('tanggal', $today)
                ->first();

            // Check if today is within internship period and not weekend
            $isInternshipDay = false;
            if ($pengajuan) {
                $startDate = Carbon::parse($pengajuan->tanggal_mulai);
                $endDate = Carbon::parse($pengajuan->tanggal_selesai);
                $isInternshipDay = $today->between($startDate, $endDate) && !$today->isWeekend();
            }

            $todayAttendance[] = [
                'user' => $intern,
                'pengajuan' => $pengajuan,
                'absensi' => $absensi,
                'isInternshipDay' => $isInternshipDay,
            ];
        }

        // Count attendance stats for today
        $attendanceStats = [
            'hadir' => collect($todayAttendance)->filter(fn($a) => $a['absensi'] && $a['absensi']->status === 'hadir')->count(),
            'izin' => collect($todayAttendance)->filter(fn($a) => $a['absensi'] && $a['absensi']->status === 'izin')->count(),
            'sakit' => collect($todayAttendance)->filter(fn($a) => $a['absensi'] && $a['absensi']->status === 'sakit')->count(),
            'belum_absen' => collect($todayAttendance)->filter(fn($a) => !$a['absensi'] && $a['isInternshipDay'])->count(),
            'total_active' => count($activeInterns),
        ];

        return view('admin.dashboard', compact('pengajuanStats', 'todayAttendance', 'attendanceStats', 'today'));
    }

    public function get_daftar_pengajuan()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.daftar-pengajuan');
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

    public function terima_final($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);

        if ($pengajuan == null) {
            abort(404);
        }

        $pengajuan->status_pengajuan = "accept-final";
        $catatan = request('catatan');
        $pengajuan->komentar = $catatan;
        $pengajuan->save();

        // Update status_magang user menjadi aktif
        $pengajuan->user->status_magang = 'aktif';
        $pengajuan->user->save();

        return redirect(url('/daftar-pengajuan'))->with([
            'success' => [
                "title" => "Berhasil menerima pengajuan final",
            ]
        ]);
    }

    public function tolak_final($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);

        if ($pengajuan == null) {
            abort(404);
        }

        $pengajuan->status_pengajuan = "reject-final";
        $catatan = request('catatan');
        $pengajuan->komentar = $catatan;
        $pengajuan->save();

        // Reset status_magang user
        $pengajuan->user->status_magang = 'tidak-aktif';
        $pengajuan->user->save();

        return redirect(url('/daftar-pengajuan'))->with([
            'success' => [
                "title" => "Berhasil menolak pengajuan final",
            ]
        ]);
    }

    public function get_monitor_absensi()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.monitor-absensi');
    }

    public function get_penilaian_magang()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.penilaian-magang');
    }

    public function get_generate_sertifikat()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.generate-sertifikat');
    }
}
