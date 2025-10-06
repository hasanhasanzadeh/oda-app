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
            $table->string('name');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->json('property')->nullable();
            $table->string('original_price')->default('0');
            $table->string('buy_price')->default('0');
            $table->string('price');
            $table->integer('quantity');
            $table->string('discount')->default('0');

            $table->enum('status', ['active', 'inactive','soon'])->default('active');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id','categories_products_category_id_fk')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('photo_id');
            $table->foreign('photo_id','files_products_photo_id_fk')->references('id')->on('files')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('categories_products_category_id_fk');
            $table->dropForeign('files_products_photo_id_fk');
            $table->dropIfExists();
        });
    }
};
