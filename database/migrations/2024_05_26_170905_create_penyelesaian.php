<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyelesaian', function (Blueprint $table) {
            $table->id();
            $table->string("kode_mapel");
            $table->integer("nomor_ujian");
            $table->integer("penugasan_id");
            $table->tinyInteger("is_end");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyelesaian');
    }
};
