<?php

namespace App\Jobs;

use App\Models\Pengajuan; // Pastikan untuk mengimpor model Pengajuan
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePengajuanStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pengajuan;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Pengajuan $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Cek apakah tenggat waktu telah berlalu
        if ($this->pengajuan->tenggat <= Carbon::now()) {
            $this->pengajuan->status_pengajuan = 'reject-time';
            $this->pengajuan->save();
        }
    }
}
