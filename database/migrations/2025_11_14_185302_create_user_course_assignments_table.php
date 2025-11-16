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
        Schema::create('USER_COURSE_ASSIGNMENTS', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('USER_ID');
            $table->unsignedBigInteger('COURSE_ID');
            $table->timestamp('ASSIGNED_AT')->useCurrent();
            $table->timestamp('COMPLETED_AT')->nullable();
            $table->integer('PROGRESS_PERCENTAGE')->default(0);
            $table->timestamp('CREATED_AT')->useCurrent();
            $table->timestamp('UPDATED_AT')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('USER_ID')->references('ID')->on('USERS')->onDelete('cascade');
            $table->foreign('COURSE_ID')->references('ID')->on('COURSES')->onDelete('cascade');
            $table->unique(['USER_ID', 'COURSE_ID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('USER_COURSE_ASSIGNMENTS');
    }
};
