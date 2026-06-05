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
        Schema::table('notebooks', function (Blueprint $table) {

            $table->string('user_name')->nullable()->change();

            $table->string('user_rut')->nullable()->change();

            $table->string('position')->nullable()->change();

            $table->string('company_name')->nullable()->change();

            $table->date('delivery_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
