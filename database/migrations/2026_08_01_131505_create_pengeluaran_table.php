<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->unsignedInteger('id_pengeluaran')->autoIncrement();
            $table->unsignedInteger('id_iuran')->nullable();
            $table->decimal('nominal', 15, 2);
            $table->date('tanggal');
            $table->string('keterangan', 255)->nullable();
            $table->string('bukti', 255)->nullable();

            // Foreign Key Relation
            $table->foreign('id_iuran', 'pengeluaran_ibfk_1')
                  ->references('id_iuran')
                  ->on('jenis_iuran')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
