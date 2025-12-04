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
        Schema::create('PRODUCTS', function (Blueprint $table) {
            $table->id('ID');
            $table->string('NAME');
            $table->text('DESCRIPTION')->nullable();
            $table->string('SKU')->unique()->nullable();
            $table->string('IMAGE_URL')->nullable();
            $table->string('STRIPE_PRODUCT_ID')->nullable()->index();
            $table->boolean('IS_ACTIVE')->default(true);
            $table->json('METADATA')->nullable();
            $table->timestamps();
        });

        Schema::create('PRICES', function (Blueprint $table) {
            $table->id('ID');
            $table->foreignId('PRODUCT_ID')->constrained('PRODUCTS', 'ID')->onDelete('cascade');
            $table->integer('AMOUNT'); // in cents
            $table->string('CURRENCY', 3)->default('USD');
            $table->enum('TYPE', ['one_time', 'recurring'])->default('one_time');
            $table->string('INTERVAL')->nullable(); // month, year (for recurring)
            $table->integer('INTERVAL_COUNT')->nullable()->default(1);
            $table->string('STRIPE_PRICE_ID')->nullable()->index();
            $table->boolean('IS_ACTIVE')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PRICES');
        Schema::dropIfExists('PRODUCTS');
    }
};
