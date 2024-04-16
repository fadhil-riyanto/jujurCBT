<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations., penyimpan jawaban siswa
     */
    public function up(): void
    {
        Schema::create('on_runtime_pilihan_ganda', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("nomor_ujian"); // identifier siswa
            $table->string("mata_pelajaran"); // identifier soak
            $table->string("pilihan_text"); 
            $table->integer("index_jawaban");

            $table->boolean("state"); // betul atau salah
            $table->timestamps();
        });

        Schema::create('on_runtime_essay', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("nomor_ujian");
            $table->string("mata_pelajaran");
            $table->string("jawaban_txt");
            $table->integer("index_jawaban");

            $table->boolean("state"); // betul atau salah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('on_runtime_pilihan_ganda');
        Schema::dropIfExists("on_runtime_essay");
    }
};
