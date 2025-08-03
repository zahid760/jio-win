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
        Schema::create('passbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('bid_id')->constrained('bids');
            $table->integer('game_number')->nullable();
            $table->integer('points')->nullable();
            $table->decimal('prev_balance', 30, 2)->nullable();
            $table->decimal('current_balance', 30, 2)->nullable();
            $table->foreignId('winner_id')->nullable()->constrained('winners');
            $table->integer('status')->default(0)->comment('0 for pending 1 for win 2 for loose');
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
        Schema::dropIfExists('passbooks');
    }
};
