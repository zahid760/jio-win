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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->foreignId('game_id')->constrained('game_masters');
            $table->foreignId('game_mode')->constrained('game_modes');
            $table->string('game_type')->nullable();
            $table->decimal('wallet_current_balance', 30, 2)->nullable();
            $table->decimal('wallet_prev_balance', 30, 2)->nullable();
            $table->decimal('total_points', 30, 2)->nullable();
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
        Schema::dropIfExists('bids');
    }
};
