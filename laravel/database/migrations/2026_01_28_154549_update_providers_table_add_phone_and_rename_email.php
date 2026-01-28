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
        if (Schema::hasTable('providers')) {
            Schema::table('providers', function (Blueprint $table) {
                // Agregar columna phone si no existe
                if (!Schema::hasColumn('providers', 'phone')) {
                    $table->string('phone')->nullable()->after('email');
                }
            });

            // Renombrar contact_email a email si existe y email no existe
            if (Schema::hasColumn('providers', 'contact_email') && !Schema::hasColumn('providers', 'email')) {
                DB::statement('ALTER TABLE providers RENAME COLUMN contact_email TO email');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('providers')) {
            Schema::table('providers', function (Blueprint $table) {
                // Eliminar columna phone si existe
                if (Schema::hasColumn('providers', 'phone')) {
                    $table->dropColumn('phone');
                }
            });

            // Renombrar email a contact_email si existe
            if (Schema::hasColumn('providers', 'email') && !Schema::hasColumn('providers', 'contact_email')) {
                DB::statement('ALTER TABLE providers RENAME COLUMN email TO contact_email');
            }
        }
    }
};
