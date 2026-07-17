<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
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
    }
};
