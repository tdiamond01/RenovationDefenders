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
            $table->unsignedBigInteger('COURSE_ID')->nullable()->after('ID');
            $table->foreign('COURSE_ID')->references('ID')->on('COURSES')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('VIDEOS', function (Blueprint $table) {
            $table->dropForeign(['COURSE_ID']);
            $table->dropColumn('COURSE_ID');
        });
    }
};
