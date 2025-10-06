<?php

use Carbon\Carbon;
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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->boolean('status')->default(false);

            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id','users_blogs_author_id_fk')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('video_id')->nullable();
            $table->foreign('video_id','files_blogs_video_id_fk')
                ->references('id')
                ->on('files')
                ->onDelete('set null');
            $table->date('publish_date')->default(Carbon::now()->format('Y-m-d'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign('users_blogs_author_id_fk');
            $table->dropForeign('files_blogs_video_id_fk');
            $table->dropIfExists();
        });
    }
};
