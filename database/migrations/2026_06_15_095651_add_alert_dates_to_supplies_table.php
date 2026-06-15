<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplies', function (Blueprint $table) {

            $table->timestamp(
                'last_critical_alert_at'
            )->nullable();

            $table->timestamp(
                'last_out_alert_at'
            )->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('supplies', function (Blueprint $table) {

            $table->dropColumn([
                'last_critical_alert_at',
                'last_out_alert_at',
            ]);

        });
    }
};