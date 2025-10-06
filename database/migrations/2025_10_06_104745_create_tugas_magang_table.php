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
        Schema::create('tugas_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_magang_id')
                ->constrained('peserta_magang')
                ->cascadeOnDelete();

            // data tugas
            $table->string('judul', 150);
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_diberikan')->default(now());
            $table->date('tenggat_waktu')->nullable();

            // file dan status
            $table->string('lampiran')->nullable(); // file dari admin
            $table->enum('status', ['belum_dikerjakan', 'dikerjakan', 'selesai'])
                ->default('belum_dikerjakan');

            // pengumpulan peserta
            $table->string('file_pengumpulan')->nullable(); // file dari peserta
            $table->date('tanggal_pengumpulan')->nullable();

            // evaluasi admin
            $table->text('catatan_admin')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_magang');
    }
};
