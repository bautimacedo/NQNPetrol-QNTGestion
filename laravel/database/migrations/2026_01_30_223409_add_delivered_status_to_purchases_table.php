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
        // Para PostgreSQL, necesitamos modificar el tipo enum directamente
        DB::statement("ALTER TABLE purchases DROP CONSTRAINT IF EXISTS purchases_status_check");
        DB::statement("ALTER TABLE purchases ADD CONSTRAINT purchases_status_check CHECK (status IN ('pending', 'authorized', 'paid', 'canceled', 'delivered'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir al estado original
        DB::statement("ALTER TABLE purchases DROP CONSTRAINT IF EXISTS purchases_status_check");
        DB::statement("ALTER TABLE purchases ADD CONSTRAINT purchases_status_check CHECK (status IN ('pending', 'authorized', 'paid', 'canceled'))");
    }
};
