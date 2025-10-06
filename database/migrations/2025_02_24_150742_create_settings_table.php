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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url')->nullable();
            $table->text('copy_right')->nullable();
            $table->longText('description')->nullable();
            $table->string('address')->nullable();
            $table->string('short_text')->nullable();
            $table->string('tel')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('support_text')->nullable();

            $table->unsignedBigInteger('logo_id')->nullable();
            $table->unsignedBigInteger('favicon_id')->nullable();

            $table->foreign('logo_id','files_settings_logo_id_fk')
                ->references('id')
                ->on('files')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreign('favicon_id','files_settings_favicon_id_fk')
                ->references('id')
                ->on('files')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign('files_settings_logo_id_fk');
            $table->dropForeign('files_settings_favicon_id_fk');
            $table->dropIfExists();
        });
    }
};
