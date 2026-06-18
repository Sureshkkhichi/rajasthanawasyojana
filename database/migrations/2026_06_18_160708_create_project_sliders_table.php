<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_sliders', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('project_id');

            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->string('image');

            $table->integer('sort_order')->default(0);

            // Homepage Hero Slider
            $table->enum('show_on_homepage', ['yes', 'no'])
                ->default('no');

            $table->enum('is_active', ['active', 'inactive'])
                ->default('active');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            $table->index('project_id');
            $table->index('sort_order');
            $table->index('show_on_homepage');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_sliders');
    }
};