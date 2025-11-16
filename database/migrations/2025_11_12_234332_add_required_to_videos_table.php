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
        Schema::table('VIDEOS', function (Blueprint $table) {
            $table->boolean('REQUIRED')->default(false)->after('IS_ACTIVE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('VIDEOS', function (Blueprint $table) {
            $table->dropColumn('REQUIRED');
        });
    }
};
