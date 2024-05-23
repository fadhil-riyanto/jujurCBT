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
        Schema::table('on_runtime_pilihan_ganda', function (Blueprint $table) {
            //
            $table->dropColumn("pilihan_text");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('on_runtime_pilihan_ganda', function (Blueprint $table) {
            //
            $table->string("pilihan_text")->nullable();
        });
    }
};
