<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Create frontend_settings table
        Schema::create('frontend_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 2. Create information_images table
        Schema::create('information_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image_path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 3. Add featured_image to projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->string('featured_image')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('featured_image');
        });
        Schema::dropIfExists('information_images');
        Schema::dropIfExists('frontend_settings');
    }
};
