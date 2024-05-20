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
            $table->boolean("is_correct")->nullable();
        });

        Schema::table('on_runtime_essay', function (Blueprint $table) {
            $table->boolean("is_correct")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('on_runtime_pilihan_ganda', function (Blueprint $table) {
            $table->dropColumn("is_correct");
        });

        Schema::table('on_runtime_essay', function (Blueprint $table) {
            $table->dropColumn("is_correct");
        });
    }
    }
};
