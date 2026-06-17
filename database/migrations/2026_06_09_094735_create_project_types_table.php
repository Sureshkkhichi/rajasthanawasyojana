<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('project_type');
            $table->text('description')->nullable();
            $table->enum('is_active', ['yes', 'no'])->default('yes');
            $table->foreignUuid('created_by')->nullable();
            $table->foreignUuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('project_types');
    }
};