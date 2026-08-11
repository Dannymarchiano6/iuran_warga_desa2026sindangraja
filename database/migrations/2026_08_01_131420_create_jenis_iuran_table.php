<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_iuran', function (Blueprint $table) {
            $table->unsignedInteger('id_iuran')->autoIncrement();
            $table->unsignedInteger('id_kategori_iuran')->nullable();
            $table->string('nama_iuran', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('jumlah', 12, 2);
            $table->integer('minggu_ke');
            $table->date('tanggal');
            $table->timestamp('created_at')->useCurrent();

            // Foreign Key Relation
            $table->foreign('id_kategori_iuran', 'fk_jenis_kategori')
                  ->references('id_kategori_iuran')
                  ->on('kategori_iuran')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_iuran');
    }
};
