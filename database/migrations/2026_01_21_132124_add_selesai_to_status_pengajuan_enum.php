<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify enum to add 'selesai' status
        DB::statement("ALTER TABLE pengajuan MODIFY COLUMN status_pengajuan ENUM('waiting', 'reject-time', 'reject-admin', 'reject-final', 'accept-first', 'accept-final', 'selesai') DEFAULT 'waiting'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pengajuan MODIFY COLUMN status_pengajuan ENUM('waiting', 'reject-time', 'reject-admin', 'reject-final', 'accept-first', 'accept-final') DEFAULT 'waiting'");
    }
};
