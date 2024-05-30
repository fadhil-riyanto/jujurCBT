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
        Schema::table('daftar_mata_pelajaran', function (Blueprint $table) {
            $table->integer("bobot_persen_essay")->default(25);;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_mata_pelajaran', function (Blueprint $table) {
            $table->dropColumn("bobot_persen_essay");
        });
    }
};
