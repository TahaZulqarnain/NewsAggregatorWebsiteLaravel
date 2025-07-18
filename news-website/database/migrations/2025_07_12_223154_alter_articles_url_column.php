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
        Schema::table('articles', function (Blueprint $table) {
            $table->text('url')->change(); // Change url to text
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('articles', function (Blueprint $table) {
            $table->string('url')->change(); // Revert if needed
        });
    }
};
