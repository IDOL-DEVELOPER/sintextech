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
        // migration file
        Schema::create('blog_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained('blog')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('category')->onDelete('cascade'); // Updated 'category' table name
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_category');
    }
};
