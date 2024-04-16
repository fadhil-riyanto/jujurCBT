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
        Schema::create('siswa_account', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("kelas");
            $table->bigInteger("nomor_ujian"); // identifier utama
            $table->string("password");
            $table->boolean("blokir")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {       
        Schema::dropIfExists('aiswa_account');
        
    }
};
