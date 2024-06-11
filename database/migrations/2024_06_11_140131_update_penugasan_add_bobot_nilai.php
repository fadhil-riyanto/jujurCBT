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
        Schema::table("penugasan", function(Blueprint $table) {
            $table->integer("bobot_essay")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("penugasan", function(Blueprint $table) {
            $table->dropColumn("bobot_essay");
        });
    }
};
