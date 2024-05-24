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
        Schema::table('on_runtime_essay', function (Blueprint $table) {
            $table->dropColumn("state");
            $table->renameColumn('index_jawaban', 'id_soal');
            $table->text("jawaban_txt")->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('on_runtime_essay', function (Blueprint $table) {
            //
            $table->tinyInteger("state")->nullable();
            $table->renameColumn('id_soal', 'index_jawaban');
            $table->string("jawaban_txt")->change();
        });
    }
};
