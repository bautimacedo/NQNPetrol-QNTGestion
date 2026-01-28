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
        // Eliminar la foreign key antigua si existe (usando SQL directo para PostgreSQL)
        $constraintName = DB::selectOne("
            SELECT constraint_name 
            FROM information_schema.table_constraints 
            WHERE table_name = 'license' 
            AND constraint_type = 'FOREIGN KEY' 
            AND constraint_name LIKE '%pilot_id%'
        ");

        if ($constraintName) {
            DB::statement("ALTER TABLE license DROP CONSTRAINT IF EXISTS {$constraintName->constraint_name}");
        }

        // Renombrar la columna usando SQL directo (más compatible con PostgreSQL)
        DB::statement('ALTER TABLE license RENAME COLUMN pilot_id TO authorized_user_id');

        // Agregar la nueva foreign key
        Schema::table('license', function (Blueprint $table) {
            $table->foreign('authorized_user_id')
                  ->references('id')
                  ->on('authorized_users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la foreign key nueva si existe
        $constraintName = DB::selectOne("
            SELECT constraint_name 
            FROM information_schema.table_constraints 
            WHERE table_name = 'license' 
            AND constraint_type = 'FOREIGN KEY' 
            AND constraint_name LIKE '%authorized_user_id%'
        ");

        if ($constraintName) {
            DB::statement("ALTER TABLE license DROP CONSTRAINT IF EXISTS {$constraintName->constraint_name}");
        }

        // Renombrar de vuelta a pilot_id usando SQL directo
        DB::statement('ALTER TABLE license RENAME COLUMN authorized_user_id TO pilot_id');

        // Restaurar la foreign key antigua (si la tabla pilots existe)
        if (Schema::hasTable('pilots')) {
            Schema::table('license', function (Blueprint $table) {
                $table->foreign('pilot_id')
                      ->references('id')
                      ->on('pilots')
                      ->onDelete('cascade');
            });
        }
    }
};
