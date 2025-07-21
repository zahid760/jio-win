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
        Schema::create('notifications_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('matka_game')->nullable();
            $table->string('satta_game')->nullable();
            $table->integer('status')->default(1)->comment('1 = ON, 0 = OFF');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications_settings');
    }
};
