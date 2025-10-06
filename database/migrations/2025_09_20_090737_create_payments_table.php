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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_payments_user_id_fk')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('paymentable_id')->nullable();
            $table->string('paymentable_type')->nullable();
            $table->string('reference_id')->nullable();
            $table->string('transaction_id')->nullable()->unique();
            $table->enum('status',['pending','failed','done'])->default('pending')->index();
            $table->string('amount',15);
            $table->text('transaction_result')->nullable(true);
            $table->index(['paymentable_type', 'paymentable_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('users_payments_user_id_fk');
            $table->dropIfExists();
        });
    }
};
