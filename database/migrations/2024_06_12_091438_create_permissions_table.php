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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uid')->onDelete('cascade');
            $table->string('user_type');
            $table->foreignId('mid')->nullable()->onDelete('cascade');
            $table->foreignId('subid')->nullable()->onDelete('cascade');
            $table->boolean('read')->default(false);
            $table->boolean('write')->default(false);
            $table->boolean('update')->default(false);
            $table->boolean('delete')->default(false);
            $table->boolean('rights')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
