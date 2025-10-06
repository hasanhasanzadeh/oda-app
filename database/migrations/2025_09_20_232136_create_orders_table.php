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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_orders_user_id_fk')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id','payments_payment_id_fk')->references('id')->on('payments')->cascadeOnDelete();

            $table->enum('status',['pending','processing','completed','cancelled'])->default('pending');
            $table->string('amount');
            $table->string('post_price')->default('0');
            $table->string('off_price')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
