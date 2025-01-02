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
        Schema::create('mobile_templates', function (Blueprint $table) {
            $table->id();
            $table->string('Variant SKU')->index()->nullable();
            $table->string('Title')->nullable();
            $table->string('Handle')->nullable();
            $table->string('Brand')->index()->nullable();
            $table->string('gtin')->index()->nullable();
            $table->string('item_model_number')->index()->nullable();
            $table->string('color')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_template');
    }
};
