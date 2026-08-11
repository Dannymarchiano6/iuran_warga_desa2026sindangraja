<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_iuran', function (Blueprint $table) {
            $table->unsignedInteger('id_kategori_iuran')->autoIncrement();
            $table->string('nama_kategori', 100);
            $table->enum('sifat', ['wajib', 'sukarela', 'kondisional'])->default('wajib');
            $table->text('deskripsi')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_iuran');
    }
};
