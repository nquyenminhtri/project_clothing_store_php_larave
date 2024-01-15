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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('color_id');
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('quantity');
            $table->timestamps();

            $table ->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table ->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table -> foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
            $table ->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};