<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_phones', function (
            Blueprint $table
        ) {

            $table->dropForeign([
                'created_by'
            ]);

            $table->dropForeign([
                'updated_by'
            ]);

            $table->dropColumn([
                'created_by',
                'updated_by'
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('employee_phones', function (
            Blueprint $table
        ) {

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

        });
    }
};