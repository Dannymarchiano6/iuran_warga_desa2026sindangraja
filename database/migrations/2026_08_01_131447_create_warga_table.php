<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->unsignedInteger('id_warga')->autoIncrement();
            $table->unsignedInteger('id_kk')->nullable();
            $table->string('nik', 16)->unique();
            $table->string('nama', 100)->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('status_keluarga', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 15)->nullable();

            // Foreign Key Relation
            $table->foreign('id_kk', 'fk_warga_kk')
                  ->references('id_kk')
                  ->on('kartu_keluarga')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
