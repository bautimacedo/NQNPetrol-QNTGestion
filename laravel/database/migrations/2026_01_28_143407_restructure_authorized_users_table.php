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
        // Agregar columna id primero (antes de eliminar la PK)
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
        });

        // Eliminar la clave primaria actual
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->dropPrimary(['user_telegram_id']);
        });

        // Establecer id como nueva clave primaria
        DB::statement('ALTER TABLE authorized_users ADD PRIMARY KEY (id)');

        // Hacer user_telegram_id único pero no primario
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_telegram_id')->unique()->change();
        });

        // Agregar las nuevas columnas de pilots
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->string('dni')->nullable()->after('user_telegram_id');
            $table->string('full_name')->nullable()->after('dni');
            $table->integer('status')->nullable()->default(0)->after('full_name');
            $table->string('profile_photo_path')->nullable()->after('status');
            $table->foreignId('web_user_id')->nullable()->after('profile_photo_path')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authorized_users', function (Blueprint $table) {
            // Eliminar foreign key
            $table->dropForeign(['web_user_id']);
            
            // Eliminar unique constraint de user_telegram_id
            $table->dropUnique(['user_telegram_id']);
        });

        // Eliminar PK de id
        DB::statement('ALTER TABLE authorized_users DROP CONSTRAINT authorized_users_pkey');

        Schema::table('authorized_users', function (Blueprint $table) {
            // Eliminar columnas agregadas
            $table->dropColumn(['id', 'dni', 'full_name', 'status', 'profile_photo_path', 'web_user_id']);
        });

        // Restaurar user_telegram_id como clave primaria
        DB::statement('ALTER TABLE authorized_users ADD PRIMARY KEY (user_telegram_id)');
    }
};
