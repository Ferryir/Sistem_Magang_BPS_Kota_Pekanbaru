<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            //biodata
            $table->string('foto_profil')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_hp');
            $table->string('tentang_saya')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->enum('status_magang', ['aktif', 'masa-daftar', 'tidak-aktif'])->default('tidak-aktif')->nullable();
            //akademik
            $table->string('institusi');
            $table->string('jurusan');
            $table->string('nomor_induk')->unique();
            $table->string('kartu_penduduk')->nullable();
            $table->string('original_filename_ktp')->nullable();
            $table->string('kartu_tanda');
            $table->string('original_filename_kartu')->nullable();
            $table->timestamps();
        });

        Schema::create('pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name');
            $table->string('fungsi_bagian');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_induk')->unique();
            $table->enum('role_temp', ['regular', 'admin'])->default('regular')->nullable();
            $table->timestamps();
        });

        Schema::create('pengajuan', function (Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('jenis_magang');
            $table->string('bidang_tujuan');
            $table->text('komentar')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tenggat')->nullable();
            $table->enum('status_pengajuan', ['waiting', 'reject-time', 'reject-admin', 'reject-final', 'accept-first', 'accept-final'])->default('waiting');
            $table->string('surat_pengantar')->nullable();
            $table->string('original_filename_surat_pengantar')->nullable();
            $table->timestamps();

            //data akademik peserta
            $table->string('institusi');
            $table->string('jurusan');
            $table->string('nomor_induk');

            //data pribadi peserta
            $table->string('foto_profil')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('nomor_hp');
            $table->string('tentang_saya');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat');

            $table->string('kartu_penduduk');
            $table->string('original_filename_ktp');
            $table->string('kartu_tanda');
            $table->string('original_filename_kartu');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('user_id')->nullable()->index(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('pegawai_id')->nullable()->index(); 
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');  
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('pengajuan');
        Schema::dropIfExists('users');
        Schema::dropIfExists('pegawai');
        Schema::dropIfExists('password_reset_tokens');
    }
};
