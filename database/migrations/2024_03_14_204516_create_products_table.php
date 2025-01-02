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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('category_id')->index();
            // $table->smallInteger('category_id')->unsigned()->index();
            $table->string('product_code', 25)->index()->nullable();
            $table->string('sap_code')->index()->nullable();
            // $table->string('sku')->unique();
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->string('status')->nullable()->index();
            $table->unsignedInteger('popularity')->default(0);
            $table->string('url');
            $table->string('image_url')->nullable();
            $table->json('product_data')->nullable();
            $table->timestamps();

            // Foreign key constraint
            //$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
