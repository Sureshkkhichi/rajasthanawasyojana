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
        Schema::table('agents', function (Blueprint $table) {
            if (Schema::hasColumn('agents', 'commission_type')) {
                $table->dropColumn('commission_type');
            }
            if (Schema::hasColumn('agents', 'commission_value')) {
                $table->dropColumn('commission_value');
            }
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->string('commission_type')->default('percentage')->nullable();
            $table->decimal('commission_value', 10, 2)->default(0)->nullable();
        });
    }
};
