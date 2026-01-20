<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->string('kartu_penduduk')->nullable()->change();
            $table->string('kartu_tanda')->nullable()->change();
            $table->string('original_filename_ktp')->nullable()->change();
            $table->string('original_filename_kartu')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->string('kartu_penduduk')->nullable(false)->change();
            $table->string('kartu_tanda')->nullable(false)->change();
            $table->string('original_filename_ktp')->nullable(false)->change();
            $table->string('original_filename_kartu')->nullable(false)->change();
        });
    }
};
