<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('nik', 16)->nullable();
            $table->unsignedInteger('id_iuran');
            $table->string('jenis_iuran', 100)->nullable();
            $table->decimal('jumlah', 12, 2)->nullable();
            $table->enum('status', ['Lunas', 'Tidak Lunas'])->default('Tidak Lunas');
            $table->timestamp('created_at')->useCurrent();
            $table->tinyInteger('is_printed')->default(0);

            // Foreign Key Relations
            $table->foreign('nik', 'fk_pembayaran_warga')
                  ->references('nik')
                  ->on('warga')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('id_iuran', 'fk_pembayaran_iuran')
                  ->references('id_iuran')
                  ->on('jenis_iuran')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
