<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_iuran', function (Blueprint $table) {
            $table->unsignedInteger('id_periode')->autoIncrement();
            $table->unsignedInteger('id_iuran');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->date('tanggal_jatuh_tempo');
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('created_at')->useCurrent();

            // Foreign Key Relation
            $table->foreign('id_iuran', 'periode_ibfk_1')
                  ->references('id_iuran')
                  ->on('jenis_iuran')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_iuran');
    }
};
