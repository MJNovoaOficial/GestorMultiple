<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->foreignId('created_by')
                ->constrained('users')
                ->noActionOnDelete();

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

    public function down(): void
    {
        Schema::dropIfExists('document_categories');
    }
};