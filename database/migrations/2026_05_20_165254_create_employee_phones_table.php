<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_phones', function (
            Blueprint $table
        ) {

            $table->id();

            $table->string('phone_number')
                ->nullable();

            $table->string('first_name');

            $table->string('last_name');

            $table->string('phone_model');

            $table->date('delivery_date')
                ->nullable();

            $table->string('imei')
                ->unique();

            $table->string('position')
                ->nullable();

            $table->string('department')
                ->nullable();

            $table->string('vendor_code')
                ->nullable();

            $table->string('company_name')
                ->nullable();

            $table->string('rut')
                ->nullable();

            $table->string('email')
                ->nullable();

            $table->text('observations')
                ->nullable();

            $table->enum('status', [

                'active',
                'returned',
                'blocked',
                'warehouse',

            ])->default('active');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('created_at')->default(DB::raw('GETDATE()'));

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_phones');
    }
};