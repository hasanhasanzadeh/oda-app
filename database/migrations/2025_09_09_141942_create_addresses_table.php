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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('receptor_name',150)->nullable();
            $table->string('receptor_mobile',15)->nullable();
            $table->string('receptor_postal_code',10)->nullable();
            $table->string('receptor_address',250)->nullable();

            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id','cities_addresses_city_id_fk')->references('id')->on('cities')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('user_id')->index();
            $table->foreign(['user_id'], 'users_addresses_user_id_fk')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('cities_addresses_city_id_fk');
            $table->dropForeign('users_addresses_user_id_fk');
            $table->dropIfExists();
        });
    }
};
