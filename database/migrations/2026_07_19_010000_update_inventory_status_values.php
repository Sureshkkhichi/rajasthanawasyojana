<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update inventories status
        DB::table('inventories')->where('status', 'Booked')->update(['status' => 'Sold']);
        DB::table('inventories')->where('status', 'Registered')->update(['status' => 'Alloted']);

        // 2. Update inventory_histories status values
        DB::table('inventory_histories')->where('from_status', 'Booked')->update(['from_status' => 'Sold']);
        DB::table('inventory_histories')->where('to_status', 'Booked')->update(['to_status' => 'Sold']);
        DB::table('inventory_histories')->where('from_status', 'Registered')->update(['from_status' => 'Alloted']);
        DB::table('inventory_histories')->where('to_status', 'Registered')->update(['to_status' => 'Alloted']);
    }

    public function down(): void
    {
        // Rollback updates
        DB::table('inventories')->where('status', 'Sold')->update(['status' => 'Booked']);
        DB::table('inventories')->where('status', 'Alloted')->update(['status' => 'Registered']);

        DB::table('inventory_histories')->where('from_status', 'Sold')->update(['from_status' => 'Booked']);
        DB::table('inventory_histories')->where('to_status', 'Sold')->update(['to_status' => 'Booked']);
        DB::table('inventory_histories')->where('from_status', 'Alloted')->update(['from_status' => 'Registered']);
        DB::table('inventory_histories')->where('to_status', 'Alloted')->update(['to_status' => 'Registered']);
    }
};
