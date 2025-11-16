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
        Schema::create('VIDEO_PROGRESS', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('USER_ID');
            $table->unsignedBigInteger('VIDEO_ID');
            $table->boolean('COMPLETED')->default(false);
            $table->integer('WATCH_TIME')->default(0); // in seconds
            $table->timestamp('COMPLETED_AT')->nullable();
            $table->timestamp('CREATED_AT')->useCurrent();
            $table->timestamp('UPDATED_AT')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('USER_ID')->references('ID')->on('USERS')->onDelete('cascade');
            $table->foreign('VIDEO_ID')->references('ID')->on('VIDEOS')->onDelete('cascade');
            $table->unique(['USER_ID', 'VIDEO_ID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('VIDEO_PROGRESS');
    }
};
