<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->unsignedInteger('id_tagihan')->autoIncrement();
            $table->unsignedInteger('id_warga');
            $table->unsignedInteger('id_iuran');
            $table->integer('minggu_ke');
            $table->decimal('jumlah', 12, 2);
            $table->enum('status', ['belum_bayar', 'lunas'])->default('belum_bayar');
            $table->timestamp('created_at')->useCurrent();

            // Foreign Key Relations
            $table->foreign('id_warga', 'tagihan_ibfk_1')
                  ->references('id_warga')
                  ->on('warga')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_iuran', 'tagihan_ibfk_2')
                  ->references('id_iuran')
                  ->on('jenis_iuran')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
