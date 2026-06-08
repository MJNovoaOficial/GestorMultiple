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
        Schema::create('radio_frequencies', function (Blueprint $table) {
            $table->id();

            $table->string('number')->unique();
            $table->string('serial')->nullable();
            $table->string('mac')->nullable();
            $table->string('ip')->nullable();

            $table->string('area')->nullable();

            $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnUpdate();

            $table->string('type');

            $table->enum('status', [
                'operative',
                'repair',
                'retired'
            ])->default('operative');

            $table->text('observations')->nullable();

            $table->boolean('blocked')->default(false);

            $table->boolean('warranty')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radio_frequencies');
    }
};
