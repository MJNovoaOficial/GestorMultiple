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
        Schema::table('credential_audit_logs', function (Blueprint $table) {

            // Eliminar foreign key
            $table->dropForeign(['email_credential_id']);

            // Eliminar columna antigua
            $table->dropColumn('email_credential_id');

            // Agregar morphs
            $table->nullableMorphs('auditable');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credential_audit_logs', function (Blueprint $table) {

            $table->dropMorphs('auditable');

            $table->unsignedBigInteger('email_credential_id')
                ->nullable();

        });
    }
};