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
        Schema::table('on_runtime_pilihan_ganda', function (Blueprint $table) {

            $table->string("pilihan_text")->nullable()->change(); 
            $table->integer("index_jawaban")->nullable()->change();
            $table->boolean("state")->nullable()->change(); // betul atau salah
        });

        Schema::table('on_runtime_essay', function (Blueprint $table) {
            $table->string("jawaban_txt")->nullable()->change();
            $table->integer("index_jawaban")->nullable()->change();
            $table->boolean("state")->nullable()->change(); // betul atau salah
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
