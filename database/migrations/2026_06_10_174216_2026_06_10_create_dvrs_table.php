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
        Schema::create('dvrs', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');

            $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('tipo', [
                'DVR',
                'NVR',
                'IPC'
            ]);

            $table->string('modelo')->nullable();
            $table->string('mp')->nullable();
            $table->string('hdd')->nullable();

            $table->string('sn')->nullable();

            $table->string('ip')->nullable();

            $table->text('password')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dvrs');
    }
};
