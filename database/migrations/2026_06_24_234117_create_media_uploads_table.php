<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('mime_type', 100);
            $table->unsignedInteger('size');
            $table->longText('contents');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_uploads');
    }
};
