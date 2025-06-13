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
        Schema::create('game_rates', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->foreignId('gamemode')->nullable()->constrained('game_modes');
            $table->decimal('bidding_rate', 10,2)->nullable();
            $table->decimal('winning_rate')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_rates');
    }
};
