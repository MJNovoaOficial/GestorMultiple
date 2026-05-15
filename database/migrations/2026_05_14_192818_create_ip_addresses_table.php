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
        Schema::create('ip_addresses', function (Blueprint $table) {
            $table->id();

            $table->ipAddress('ip_address')->unique();

            $table->foreignId('branch_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('department_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('device_type_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('ip_status_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('hostname')->nullable();

            $table->string('mac_address')->nullable();

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_addresses');
    }
};
