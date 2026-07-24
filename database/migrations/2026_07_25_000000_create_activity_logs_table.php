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
        Schema::dropIfExists('activity_logs');

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->nullable()->index();
            $table->string('log_type')->default('system'); // lead, deal, inventory, system
            $table->unsignedBigInteger('lead_id')->nullable()->index();
            $table->unsignedBigInteger('deal_id')->nullable()->index();
            $table->unsignedBigInteger('inventory_id')->nullable()->index();
            $table->nullableMorphs('subject'); // subject_type, subject_id
            
            $table->string('title');
            $table->string('event')->nullable()->index(); // e.g. sms_sent, email_sent, pdf_downloaded, status_changed, unit_allotted, marked_sold, marked_refund, marked_cancel, marked_not_alloted
            $table->text('description')->nullable();
            $table->json('properties')->nullable();
            $table->boolean('is_system_generated')->default(false);
            $table->timestamps();

            $table->index(['log_type', 'created_at']);
            $table->index(['lead_id', 'created_at']);
            $table->index(['deal_id', 'created_at']);
            $table->index(['inventory_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
