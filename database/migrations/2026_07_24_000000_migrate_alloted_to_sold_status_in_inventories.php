<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update inventories status from Alloted to Sold
        DB::table('inventories')->where('status', 'Alloted')->update(['status' => 'Sold']);

        // Update inventory_histories
        DB::table('inventory_histories')->where('from_status', 'Alloted')->update(['from_status' => 'Sold']);
        DB::table('inventory_histories')->where('to_status', 'Alloted')->update(['to_status' => 'Sold']);
    }

    public function down(): void
    {
        DB::table('inventories')->where('status', 'Sold')->update(['status' => 'Alloted']);
    }
};
