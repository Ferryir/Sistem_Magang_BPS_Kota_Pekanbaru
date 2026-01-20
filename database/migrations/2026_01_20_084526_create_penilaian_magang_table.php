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
        Schema::create('penilaian_magang', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->uuid('pengajuan_id');
            $table->integer('sikap_etika')->nullable(); // 0-100
            $table->integer('kemampuan_teknis')->nullable(); // 0-100
            $table->integer('kemauan_belajar')->nullable(); // 0-100
            $table->integer('kualitas_kerja')->nullable(); // 0-100
            $table->integer('komunikasi_kerjasama')->nullable(); // 0-100
            $table->decimal('nilai_akhir', 5, 2)->nullable(); // Auto calculated
            $table->text('catatan')->nullable();
            $table->uuid('penilai_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pengajuan_id')->references('id')->on('pengajuan')->onDelete('cascade');
            $table->foreign('penilai_id')->references('id')->on('pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_magang');
    }
};
