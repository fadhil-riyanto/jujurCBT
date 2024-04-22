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
        Schema::create("daftar_assignment", function(Blueprint $table) {
            $table->id();
            $table->integer("nomor_ujian");
            $table->string("jenis_mapel");
            $table->boolean("status_dikerjakan");
            $table->boolean("status_selesai");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("daftar_assignment");
    }
};
