<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'flat_id')) {
                $table->foreignUuid('flat_id')
                    ->nullable()
                    ->after('project_type_id')
                    ->constrained('flats')
                    ->cascadeOnUpdate()
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'flat_id')) {
                $table->dropConstrainedForeignId('flat_id');
            }
        });
    }
};
