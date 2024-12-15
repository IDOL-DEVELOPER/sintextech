<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cate_id');
            $table->foreign('cate_id')->references('id')->on('category')->cascadeOnDelete();
            $table->text('title');
            $table->longText('content')->nullable();
            $table->string('slug');
            $table->string('brief')->nullable();
            $table->string('views')->nullable();
            $table->string('likes')->nullable();
            $table->string('tags')->nullable();
            $table->string('image_id')->nullable();
            $table->string('auth_id')->nullable();
            $table->text('meta_key')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_desc')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
};
