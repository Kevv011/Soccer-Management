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
        Schema::create('federations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->date('foundation_date');
            $table->foreignId('subdivision_id')
                ->constrained()
                ->restrictOnDelete();
            $table->string('municipality', 150);
            $table->string('address_line', 255);
            $table->timestamps();

            $table->unique(['name', 'subdivision_id', 'municipality']);
            $table->index('foundation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federations');
    }
};
