<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi_pembayaran', function (Blueprint $table) {
            $table->unsignedInteger('id_verifikasi')->autoIncrement();
            $table->unsignedInteger('id_pembayaran')->unique();
            $table->unsignedInteger('id_bendahara');
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_revisi')->nullable();
            $table->timestamp('tanggal_verifikasi')->useCurrent()->useCurrentOnUpdate();

            // Foreign Key Relations
            $table->foreign('id_pembayaran', 'verifikasi_ibfk_1')
                  ->references('id')
                  ->on('pembayaran')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_bendahara', 'verifikasi_ibfk_2')
                  ->references('id_bendahara')
                  ->on('bendahara')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_pembayaran');
    }
};
