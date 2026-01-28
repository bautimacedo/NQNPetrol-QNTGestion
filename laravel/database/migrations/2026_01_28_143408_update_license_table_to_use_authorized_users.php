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
        // Eliminar la foreign key antigua
        Schema::table('license', function (Blueprint $table) {
            $table->dropForeign(['pilot_id']);
        });

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
        // Eliminar la foreign key nueva
        Schema::table('license', function (Blueprint $table) {
            $table->dropForeign(['authorized_user_id']);
        });

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
