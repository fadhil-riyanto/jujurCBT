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
        Schema::create('soal', function (Blueprint $table) {
            $table->id();
            $table->string("mata_pelajaran"); // nama mapel
            $table->integer("nomor_soal");

            /*
            | karna soal punya 2 sisi, sisi text dan sisi gambar(matematika)
            |
            */
            $table->string("image_soal")->nullable();
            $table->string("text_soal")->nullable();

            $table->integer("index_kunci_jawaban")->nullable(); // i.e 2 (B)
            $table->timestamps();
        });

        Schema::create('essay', function (Blueprint $table) {
            $table->id();
            $table->string("mata_pelajaran"); // nama mapel
            $table->integer("nomor_soal"); // 1, 2 , 3 etc
            /*
            | karna soal punya 2 sisi, sisi text dan sisi gambar(matematika)
            |
            */
            $table->string("image_soal");
            $table->string("text_soal");
            
            $table->timestamps();
        });

        /*
        | wadah database untuk jawaban
        */

        Schema::create('pilihan_ganda', function (Blueprint $table) {
            $table->id();
            $table->string("mata_pelajaran");
            $table->integer("nomor_soal");
            $table->string("pilihan_text");
            $table->integer("index_jawaban"); // i.e 1 to 4 (abcd)
            $table->timestamps();
        });


        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal');
        Schema::dropIfExists('pilihan_ganda');
        Schema::dropIfExists("essay");
    }
};
