<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the role_temp column to include 'pembimbing' option
        DB::statement("ALTER TABLE pegawai MODIFY COLUMN role_temp ENUM('regular', 'admin', 'pembimbing') DEFAULT 'regular'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE pegawai MODIFY COLUMN role_temp ENUM('regular', 'admin') DEFAULT 'regular'");
    }
};
