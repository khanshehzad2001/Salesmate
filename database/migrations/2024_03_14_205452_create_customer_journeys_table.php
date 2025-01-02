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
        Schema::create('customer_journeys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->decimal('phone_number',14,0);
            $table->string('email');
            $table->unsignedBigInteger('outcome_id');
            $table->text('reason')->nullable();
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('store_id');
            $table->timestamps();
    
                // Foreign key constraint
                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
                $table->foreign('email')->references('email')->on('customers')->onDelete('cascade');
                $table->foreign('outcome_id')->references('id')->on('options')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_journeys');
    }
};