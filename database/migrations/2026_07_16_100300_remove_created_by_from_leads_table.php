<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->uuid('created_by')->nullable()->after('project_id');
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }
};
