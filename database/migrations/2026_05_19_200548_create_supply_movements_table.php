<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supply_movements', function (Blueprint $table) {

            $table->id();

            $table->foreignId('supply_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->enum('type', [
                'add',
                'remove',
                'delete'
            ]);

            $table->integer('quantity');

            $table->integer('old_quantity');

            $table->integer('new_quantity');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supply_movements');
    }
};