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
        Schema::create('cj_products', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_journey_id');
            $table->unsignedBigInteger('product_id');

             // Foreign key constraints
             $table->foreign('customer_journey_id')->references('id')->on('customer_journeys')->onDelete('cascade');
             $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cj_products');
    }
};
