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
        Schema::create('USERS', function (Blueprint $table) {
            $table->id('ID');
            $table->string('NAME');
            $table->string('EMAIL')->unique();
            $table->timestamp('EMAIL_VERIFIED_AT')->nullable();
            $table->string('PASSWORD');
            $table->enum('ROLE', ['admin', 'user'])->default('user');
            $table->string('REMEMBER_TOKEN', 100)->nullable();
            $table->timestamp('CREATED_AT')->nullable();
            $table->timestamp('UPDATED_AT')->nullable();
        });

        Schema::create('PASSWORD_RESET_TOKENS', function (Blueprint $table) {
            $table->string('EMAIL')->primary();
            $table->string('TOKEN');
            $table->timestamp('CREATED_AT')->nullable();
        });

        Schema::create('SESSIONS', function (Blueprint $table) {
            $table->string('ID')->primary();
            $table->unsignedBigInteger('USER_ID')->nullable()->index();
            $table->string('IP_ADDRESS', 45)->nullable();
            $table->text('USER_AGENT')->nullable();
            $table->longText('PAYLOAD');
            $table->integer('LAST_ACTIVITY')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('USERS');
        Schema::dropIfExists('PASSWORD_RESET_TOKENS');
        Schema::dropIfExists('SESSIONS');
    }
};
