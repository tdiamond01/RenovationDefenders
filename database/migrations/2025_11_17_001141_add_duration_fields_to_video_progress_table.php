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
        Schema::table('VIDEO_PROGRESS', function (Blueprint $table) {
            $table->integer('WATCHED_DURATION')->default(0)->after('WATCH_TIME'); // Seconds watched
            $table->integer('TOTAL_DURATION')->default(0)->after('WATCHED_DURATION'); // Total video duration
            $table->timestamp('LAST_WATCHED_AT')->nullable()->after('COMPLETED_AT'); // Last time video was watched
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('VIDEO_PROGRESS', function (Blueprint $table) {
            $table->dropColumn(['WATCHED_DURATION', 'TOTAL_DURATION', 'LAST_WATCHED_AT']);
        });
    }
};
