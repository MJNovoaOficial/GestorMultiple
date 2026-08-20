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
        if (!Schema::hasColumn('document_categories', 'is_active')) {
            Schema::table('document_categories', function (Blueprint $table) {
                $table->boolean('is_active')->default(true);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('document_categories', 'is_active')) {
            Schema::table('document_categories', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};
