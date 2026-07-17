<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->uuid('allotted_inventory_id')->nullable()->after('project_id')->index();
            $table->foreign('allotted_inventory_id')->references('id')->on('inventories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropForeign(['allotted_inventory_id']);
            $table->dropColumn('allotted_inventory_id');
        });
    }
};
