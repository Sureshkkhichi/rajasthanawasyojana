<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            // Add deal_status column (Sold, Refund, Cancel, Not Alloted, etc.)
            $table->string('deal_status')->nullable()->after('status');

            // Add payment_status column — always 'Paid' for a deal
            $table->string('payment_status')->default('Paid')->after('deal_status');
        });

        // Migrate: move current 'status' into 'deal_status'
        // payment_status stays as 'Paid' (since a deal means payment was done)
        DB::statement("UPDATE deals SET deal_status = status");
    }

    public function down(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn(['deal_status', 'payment_status']);
        });
    }
};
