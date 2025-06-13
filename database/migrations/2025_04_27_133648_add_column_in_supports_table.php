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
        Schema::table('supports', function (Blueprint $table) {
            $table->string('telegram')->nullable()->after('whatsapp_no');
            $table->string('instagram')->nullable()->after('telegram');
            $table->string('call_no')->nullable()->after('instagram');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supports', function (Blueprint $table) {
            $table->dropColumn('telegram');
            $table->dropColumn('instagram');
            $table->dropColumn('call_no');
        });
    }
};
