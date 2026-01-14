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
        Schema::create('role_pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('all_pegawai_role', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pegawai_id');
            $table->uuid('role_pegawai_id');
            $table->timestamps();
        
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->foreign('role_pegawai_id')->references('id')->on('role_pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_pegawai_role');
        Schema::dropIfExists('role_pegawai');
    }
};
