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
        Schema::create('symbols', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('setting_id');
            $table->foreign('setting_id','settings_symbols_setting_id_fk')
                ->references('id')
                ->on('settings')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('title');
            $table->string('link')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('symbols', function (Blueprint $table) {
            $table->dropForeign('settings_symbols_setting_id_fk');
            $table->dropIfExists();
        });
    }
};
