<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {

            $table->uuid('id')->primary();

            // Relations
            $table->uuid('project_id');
            $table->integer('state_id')->nullable();

            // Lead Status
            $table->enum('status', [
                'awaiting_closed',
                'in_process',
                'cancelled',
                'site_visited',
                'document_collected',
            ])->default('in_process');

            // Payment Status
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
            ])->default('pending');

            // Personal Information
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('father_husband_name')->nullable();

            $table->string('pan_number')->nullable();

            $table->enum('gender', [
                'male',
                'female',
                'other',
            ])->nullable();

            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();

            $table->date('date_of_birth')->nullable();

            $table->string('occupation')->nullable();

            // Address
            $table->text('address')->nullable();
            $table->string('city')->nullable();

            // Flat Information
            $table->string('co_applicant_name')->nullable();
            $table->string('flat_size')->nullable();

            // Agent Waiver Code
            $table->string('waiver_code')->nullable();

            // Tracking
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            // Form Tracking
            $table->boolean('is_submitted')->default(false);

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();

            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->nullOnDelete();

            // Indexes
            $table->index('project_id');
            $table->index('state_id');

            $table->index('status');
            $table->index('payment_status');

            $table->index('phone');
            $table->index('email');

            $table->index('waiver_code');
            $table->index('is_submitted');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};