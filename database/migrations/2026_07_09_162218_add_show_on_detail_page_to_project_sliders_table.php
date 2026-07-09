<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('project_sliders', function (Blueprint $table) {
            $table->enum('show_on_detail_page', ['yes', 'no'])
                ->default('yes')
                ->after('show_on_homepage');
            $table->index('show_on_detail_page');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_sliders', function (Blueprint $table) {
            $table->dropIndex(['show_on_detail_page']);
            $table->dropColumn('show_on_detail_page');
        });
    }
};
