<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignUuid('project_type_id')
                ->constrained('project_types')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('city')->nullable();

            $table->text('address')->nullable();

            $table->enum('status', [
                'upcoming',
                'active',
                'completed',
                'hold',
                'cancelled'
            ])->default('upcoming');

            $table->enum('is_active', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();
            $table->softDeletes();

            $table->index('project_type_id');
            $table->index('city');
            $table->index('status');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};