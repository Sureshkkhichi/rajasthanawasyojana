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
        Schema::table('home_sliders', function (Blueprint $table) {
            $table->uuid('project_id')->after('id')->nullable();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            $table->dropColumn([
                'title',
                'subtitle',
                'mobile_image',
                'button_text',
                'button_link'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_sliders', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');

            $table->string('title')->default('');
            $table->string('subtitle')->nullable();
            $table->string('mobile_image')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
        });
    }
};
