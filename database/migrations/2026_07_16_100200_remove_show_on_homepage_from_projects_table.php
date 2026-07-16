<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Drop index first if supported / exists (SQLite needs this)
            $table->dropIndex(['show_on_homepage']);
            $table->dropColumn('show_on_homepage');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('show_on_homepage')->default('inactive');
            $table->index('show_on_homepage');
        });
    }
};
