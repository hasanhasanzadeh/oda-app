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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();;
            $table->string('mobile',18)->nullable();
            $table->string('subject')->nullable();
            $table->string('email')->nullable();
            $table->string('ip_address',20)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id','users_contacts_user_id_fk')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->boolean('read')->default('0');
            $table->text('message',500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign('users_contacts_user_id_fk');
            $table->dropIfExists();
        });
    }
};
