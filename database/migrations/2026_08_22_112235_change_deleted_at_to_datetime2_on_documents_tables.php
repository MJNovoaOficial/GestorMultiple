<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlsrv') {
            DB::statement("
                ALTER TABLE document_categories
                ALTER COLUMN deleted_at datetime2(7) NULL
            ");

            DB::statement("
                ALTER TABLE documents
                ALTER COLUMN deleted_at datetime2(7) NULL
            ");
        }
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlsrv') {
            DB::statement("
                ALTER TABLE document_categories
                ALTER COLUMN deleted_at datetime NULL
            ");

            DB::statement("
                ALTER TABLE documents
                ALTER COLUMN deleted_at datetime NULL
            ");
        }
    }
};
