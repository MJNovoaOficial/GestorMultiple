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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Categoría a la que pertenece el documento
            $table->foreignId('category_id')
                ->constrained('document_categories')
                ->restrictOnDelete();

            // Información visible para el usuario
            $table->string('name');
            $table->text('description')->nullable();

            // Información del archivo
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type', 50);
            $table->unsignedBigInteger('file_size');

            // Usuario que subió el documento
            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            // Índices
            $table->index('category_id');
            $table->index('name');

            // Fechas compatibles con MySQL y SQL Server
            if (Schema::getConnection()->getDriverName() === 'sqlsrv') {
                $table->dateTime('created_at', 7);
                $table->dateTime('updated_at', 7);
            } else {
                $table->timestamps();
            }

            // Papelera
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};