<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_warga', function (Blueprint $table) {
            $table->unsignedInteger('id_laporan')->autoIncrement();
            $table->unsignedInteger('id_warga');
            $table->string('judul_laporan', 150);
            $table->text('isi_laporan');
            $table->string('foto_bukti', 255)->nullable();
            $table->enum('status_laporan', ['terkirim', 'diproses', 'selesai', 'ditolak'])->default('terkirim');
            $table->text('tanggapan_pengurus')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Foreign Key Relation
            $table->foreign('id_warga', 'laporan_warga_ibfk_1')
                  ->references('id_warga')
                  ->on('warga')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_warga');
    }
};
