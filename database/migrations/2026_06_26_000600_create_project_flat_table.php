<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_flat', function (Blueprint $table) {
            $table->foreignUuid('project_id')
                ->constrained('projects')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignUuid('flat_id')
                ->constrained('flats')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->primary(['project_id', 'flat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_flat');
    }
};
