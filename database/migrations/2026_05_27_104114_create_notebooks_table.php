<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notebooks', function (Blueprint $table) {

            $table->id();

            // Usuario asignado
            $table->string('user_name');

            $table->string('user_rut');

            // Equipo
            $table->string('serial_number')->unique();

            $table->string('model');

            // Marca
            $table->foreignId('brand_id')
                ->constrained()
                ->cascadeOnDelete();

            // Fecha entrega
            $table->date('delivery_date');

            // Valor equipo
            $table->decimal('purchase_value', 12, 2);

            // Condición
            $table->enum('condition', [
                'new',
                'refurbished'
            ]);

            // Estado
            $table->enum('status', [
                'available',
                'assigned',
                'retired'
            ]);

            // Información laboral
            $table->string('position');

            $table->string('company_name');

            // Observaciones
            $table->text('observations')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notebooks');
    }
};