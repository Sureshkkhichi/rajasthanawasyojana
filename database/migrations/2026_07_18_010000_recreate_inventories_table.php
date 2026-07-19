<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('inventory_histories');
        Schema::dropIfExists('inventories');

        Schema::create('inventories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('inventory_type'); // plot, flat
            $table->decimal('price', 15, 2);
            $table->string('status')->default('Available'); // Available, Hold, Booked, Registered, Blocked, Cancelled
            $table->text('remarks')->nullable();

            // Plot Fields
            $table->string('plot_no')->nullable();
            $table->decimal('area_sq_yards', 10, 2)->nullable();
            $table->string('road_size')->nullable();
            $table->decimal('plc_percentage', 5, 2)->nullable();
            $table->string('plc_status')->nullable(); // e.g. Corner

            // Flat Fields
            $table->string('floor')->nullable();
            $table->string('flat_no')->nullable();
            $table->string('unit_type')->nullable(); // EWS, LIG, MIG, HIG, etc.
            $table->decimal('area_sbup', 10, 2)->nullable();
            $table->decimal('carpet_area', 10, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('inventory_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('inventory_id')->constrained('inventories')->cascadeOnDelete();
            $table->string('from_status');
            $table->string('to_status');
            $table->string('changed_by')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_histories');
        Schema::dropIfExists('inventories');
    }
};
