<?php

use App\Models\Sertifikat;
use App\Models\Pengajuan;

$sertifikats = Sertifikat::all();

foreach ($sertifikats as $sertifikat) {
    $pengajuan = Pengajuan::find($sertifikat->pengajuan_id);
    if ($pengajuan) {
        $pengajuan->update(['status_pengajuan' => 'selesai']);
        echo "Updated pengajuan: " . $pengajuan->id . "\n";
    }
}

echo "Done!\n";
