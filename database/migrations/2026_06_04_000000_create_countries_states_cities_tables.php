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
        if (DB::getDriverName() === 'sqlite') {
            // For testing environment (SQLite), just create the tables so foreign key constraints pass
            Schema::create('countries', function ($table) {
                $table->integer('id')->primary();
                $table->string('sortname', 3);
                $table->string('name', 150);
            });

            Schema::create('states', function ($table) {
                $table->integer('id')->primary();
                $table->string('name', 30);
                $table->integer('code')->nullable();
                $table->integer('country_id')->default(1);
            });

            Schema::create('cities', function ($table) {
                $table->integer('id')->primary();
                $table->string('name', 30);
                $table->integer('state_id');
            });
        } else {
            // For production/dev MySQL, load the complete schema + data dump
            if (!Schema::hasTable('countries') && !Schema::hasTable('states') && !Schema::hasTable('cities')) {
                $sqlPath = public_path('country_state_city.sql');
                if (file_exists($sqlPath)) {
                    DB::unprepared(file_get_contents($sqlPath));
                }
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
