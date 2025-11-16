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
        Schema::create('VIDEOS', function (Blueprint $table) {
            $table->id('ID');
            $table->string('TITLE');
            $table->text('DESCRIPTION')->nullable();
            $table->string('FILE_PATH');
            $table->integer('DURATION')->comment('Duration in seconds');
            $table->string('MODULE')->nullable();
            $table->integer('ORDER')->default(0);
            $table->boolean('IS_ACTIVE')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('VIDEOS');
    }
};
