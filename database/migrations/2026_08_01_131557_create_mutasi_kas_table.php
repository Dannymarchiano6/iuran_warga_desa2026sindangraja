<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutasi_kas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_mutasi')->autoIncrement();
            $table->unsignedInteger('id_pemasukan')->nullable();
            $table->unsignedInteger('id_pengeluaran')->nullable();
            $table->enum('tipe_mutasi', ['masuk', 'keluar']);
            $table->decimal('nominal', 15, 2);
            $table->decimal('saldo_akhir', 15, 2);
            $table->string('keterangan', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Foreign Key Relations
            $table->foreign('id_pemasukan', 'mutasi_ibfk_1')
                  ->references('id_pemasukan')
                  ->on('pemasukan')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('id_pengeluaran', 'mutasi_ibfk_2')
                  ->references('id_pengeluaran')
                  ->on('pengeluaran')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_kas');
    }
};
