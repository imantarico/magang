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
        Schema::table('peserta_magang', function (Blueprint $table) {
             $table->enum('status', ['daftar', 'diterima', 'aktif', 'selesai', 'ditolak'])
                ->default('daftar')
                ->after('surat_pengantar');
                 $table->date('tanggal_mulai')->nullable()->after('status');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta_magang', function (Blueprint $table) {
            //
        });
    }
};
