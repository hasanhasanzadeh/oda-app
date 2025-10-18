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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_orders_user_id_fk')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id','payments_payment_id_fk')->references('id')->on('payments')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id','address_orders_address_id_fk')->references('id')->on('addresses')->cascadeOnUpdate()->cascadeOnDelete();

            $table->decimal('subtotal' );
            $table->decimal('discount')->default(0);
            $table->decimal('tax')->default(0);
            $table->decimal('shipping')->default(0);
            $table->decimal('total');
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'refunded'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->json('shipping_address');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id','orders_items_order_id_fk')->references('id')->on('orders')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id','orders_items_product_id_fk')->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('product_name');
            $table->integer('quantity');
            $table->decimal('price');
            $table->decimal('total');
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_comments_user_id_fk')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id','products_comments_product_id_fk')->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();

            $table->text('comment');
            $table->integer('rating')->default(5);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });

        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('link')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign('orders_items_order_id_fk');
            $table->dropForeign('orders_items_product_id_fk');
            $table->dropIfExists();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('users_comments_user_id_fk');
            $table->dropForeign('products_comments_product_id_fk');
            $table->dropIfExists();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('users_orders_user_id_fk');
            $table->dropForeign('orders_items_product_id_fk');
            $table->dropForeign('address_orders_address_id_fk');
            $table->dropIfExists();
        });
    }
};
