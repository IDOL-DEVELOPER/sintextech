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
        Schema::create('permission_map', function (Blueprint $table) {
            $table->id();
            $table->string('menu_id')->nullable();
            $table->string('submenu_id')->nullable();
            $table->string('menu_map')->nullable();
            $table->string('submenu_map')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_map');
    }
};
