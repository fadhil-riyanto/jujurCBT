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
