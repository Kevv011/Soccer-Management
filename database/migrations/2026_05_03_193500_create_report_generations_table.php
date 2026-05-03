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
        Schema::create('report_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('report_type')->index();
            $table->string('status')->index();
            $table->string('selection_summary')->nullable();
            $table->string('requested_by_name');
            $table->string('requested_by_email');
            $table->string('file_disk')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->json('filters')->nullable();
            $table->timestamp('requested_at');
            $table->timestamp('completed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_generations');
    }
};
