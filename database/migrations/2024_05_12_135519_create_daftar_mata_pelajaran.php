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
        Schema::create('daftar_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string("kode_mata_pelajaran");
            $table->string("nama_mata_pelajaran");
            $table->json("pengampu")->nullable();
            $table->integer("total_soal")->default(1); // initial 1
            $table->boolean("allow_copy")->default(true);
            $table->boolean("enable_right_click")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_mata_pelajaran');
    }
};
