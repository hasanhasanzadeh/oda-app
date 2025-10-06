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
        Schema::create('order_product', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id','orders_products_order_id_fk')->references('id')->on('orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id','orders_product_product_id_fk')->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('qty');
            $table->integer('price');
            $table->integer('total_price');
            $table->integer('discount')->default(0);
            $table->primary(['order_id','product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropForeign('orders_products_order_id_fk');
            $table->dropForeign('orders_product_product_id_fk');
            $table->dropIfExists();
        });
    }
};
