<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('countries') && !Schema::hasTable('states') && !Schema::hasTable('cities')) {
            $sqlPath = public_path('country_state_city.sql');
            if (file_exists($sqlPath)) {
                DB::unprepared(file_get_contents($sqlPath));
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
    }
};
