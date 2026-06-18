<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_sliders', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title');
            $table->string('subtitle')->nullable();

            $table->string('desktop_image');
            $table->string('mobile_image')->nullable();

            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();

            $table->unsignedInteger('sort_order')->default(0);

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('sort_order');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_sliders');
    }
};