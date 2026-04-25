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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')
                ->constrained()
                ->restrictOnDelete();
            $table->string('name', 150);
            $table->date('birth_date');
            $table->string('gender', 20);
            $table->timestamps();

            $table->index(['team_id', 'name']);
            $table->index('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
