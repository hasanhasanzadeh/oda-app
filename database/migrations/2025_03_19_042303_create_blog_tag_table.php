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
        Schema::create('blog_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('blog_id','blog_tag_blog_id_fk')->references('id')->on('blogs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tag_id','blog_tag_tag_id_fk')->references('id')->on('tags')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->unique(['blog_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_tag', function (Blueprint $table) {
            $table->dropForeign('blog_tag_blog_id_fk');
            $table->dropForeign('blog_tag_tag_id_fk');
            $table->dropIfExists();
        });
    }
};
