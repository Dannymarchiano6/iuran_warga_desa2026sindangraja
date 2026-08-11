<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->unsignedInteger('id_pengumuman')->autoIncrement();
            $table->unsignedInteger('id_user');
            $table->string('judul', 200);
            $table->text('isi_pengumuman');
            $table->enum('kategori', ['biasa', 'penting', 'darurat'])->default('biasa');
            $table->string('lampiran_file', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Foreign Key Relation
            $table->foreign('id_user', 'pengumuman_ibfk_1')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
