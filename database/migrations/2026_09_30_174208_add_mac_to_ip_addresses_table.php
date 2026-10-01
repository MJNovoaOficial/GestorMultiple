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
        Schema::table('ip_addresses', function (Blueprint $table) {
            $table->string('mac', 17)->nullable()->after('ip');
        });
    }

    public function down(): void
    {
        Schema::table('ip_addresses', function (Blueprint $table) {
            $table->dropColumn('mac');
        });
    }
};
