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
        Schema::create('import_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_invoice_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('color_id');
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('quantity');
            $table->decimal('import_price',10,2);
            $table->decimal('sale_price',10,2);
            $table->decimal('import_price_total',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_invoice_details');
    }
};