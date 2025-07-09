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
        Schema::table('notifications', function (Blueprint $table) {
            $table->integer('user_id')->after('id')->nullable();
            $table->integer('winer_user_id')->after('user_id')->nullable();
            $table->integer('event_type')->nullable()
                  ->default(0)
                  ->comment('0 = generate, 1 = Deposit, 2 = Withdraw, 3 = Matka Result, 4 = Satta Result')
                  ->after('winer_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'winer_user_id', 'event_type']);
        });
    }
};
