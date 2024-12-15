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
        Schema::create('upload', function (Blueprint $table) {
            $table->id();
            $table->string('original_name')->unique();
            $table->string('file_name');
            $table->string('user_id')->nullable();
            $table->string('user_instance')->nullable();
            $table->string('file_size')->nullable();
            $table->string('extension');
            $table->string('type')->nullable();
            $table->string('external_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload');
    }
};
