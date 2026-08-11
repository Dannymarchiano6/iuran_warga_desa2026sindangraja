<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bendahara', function (Blueprint $table) {
            $table->unsignedInteger('id_bendahara')->autoIncrement();
            $table->unsignedInteger('id_user');
            $table->string('jabatan', 50)->nullable();

            // Foreign Key Relation
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bendahara');
    }
};
