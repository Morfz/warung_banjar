<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->unsignedTinyInteger('layout_x')->default(0)->after('status');
            $table->unsignedTinyInteger('layout_y')->default(0)->after('layout_x');
            $table->string('layout_shape', 24)->default('vertical')->after('layout_y');
        });
    }

    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropColumn(['layout_x', 'layout_y', 'layout_shape']);
        });
    }
};
