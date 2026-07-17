<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_id')->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_husband_name')->nullable();
            $table->string('pan_number');
            $table->string('gender');
            $table->string('email');
            $table->string('phone');
            $table->date('date_of_birth');
            $table->string('occupation');
            $table->text('address');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('state_name')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('city')->nullable();
            $table->string('co_applicant_name')->nullable();
            $table->string('flat_size');
            $table->string('waiver_code')->nullable();
            $table->dateTime('booking_date');
            $table->decimal('booking_amount', 12, 2)->default(21100.00);
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->string('status')->default('Paid');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
