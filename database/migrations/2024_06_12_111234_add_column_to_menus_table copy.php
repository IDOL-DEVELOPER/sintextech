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
        Schema::table('menus', function (Blueprint $table) {
    
            if (!Schema::hasColumn('menus', 'dflt')) {
                $table->integer('dflt')->default(0)->after('order');
            }

            if (!Schema::hasColumn('menus', 'nav')) {
                $table->integer('nav')->default(0)->after('order');
            }

            if (!Schema::hasColumn('menus', 'nextside')) {
                $table->integer('nextside')->default(0)->after('order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['dflt','nav','nextside']);
        });
    }
};
