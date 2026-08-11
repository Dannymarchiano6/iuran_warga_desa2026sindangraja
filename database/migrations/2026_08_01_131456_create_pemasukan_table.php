<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->unsignedInteger('id_pemasukan')->autoIncrement();
            $table->unsignedInteger('id_iuran')->nullable();
            $table->unsignedInteger('id_kk')->nullable();
            $table->decimal('nominal', 15, 2);
            $table->date('tanggal');
            $table->string('keterangan', 255)->nullable();
            $table->string('bukti', 255)->nullable();

            // Foreign Key Relations
            $table->foreign('id_iuran', 'pemasukan_ibfk_1')
                  ->references('id_iuran')
                  ->on('jenis_iuran')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('id_kk', 'pemasukan_ibfk_2')
                  ->references('id_kk')
                  ->on('kartu_keluarga')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemasukan');
    }
};
