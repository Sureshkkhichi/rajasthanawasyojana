<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('plot_no');
            $table->decimal('area', 10, 2);
            $table->string('road_size');
            $table->decimal('plc_percentage', 5, 2)->default(0.00);
            $table->string('facing_type')->nullable();
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('breadth', 10, 2)->nullable();
            $table->string('shape')->nullable();
            $table->text('remarks')->nullable();
            $table->decimal('price', 15, 2);
            $table->string('price_in_words')->nullable();
            $table->decimal('cost_price', 15, 2)->nullable();
            $table->string('status')->default('Available'); // Available, Hold, Booked, Registered, Blocked, Cancelled
            $table->date('status_effective_from')->nullable();
            $table->text('notes')->nullable();
            $table->json('documents')->nullable();
            $table->string('map_layout')->nullable();
            $table->string('hold_by')->nullable();
            $table->date('hold_till')->nullable();
            $table->string('booked_by')->nullable();
            $table->timestamp('booked_on')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
