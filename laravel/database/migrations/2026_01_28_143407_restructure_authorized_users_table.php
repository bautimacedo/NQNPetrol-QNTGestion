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
        // PRIMERO: Eliminar la restricción de llave primaria actual de user_telegram_id
        // Esto NO borra los datos, solo quita la restricción
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->dropPrimary(['user_telegram_id']);
        });

        // SEGUNDO: Agregar la nueva columna id como bigIncrements
        // Al haber quitado la PK anterior, esta pasará a ser la nueva llave primaria sin conflictos
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
        });

        // TERCERO: Modificar user_telegram_id para que sea único pero no PK
        // Esto asegura que el bot de Telegram siga funcionando con IDs únicos
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_telegram_id')->unique()->change();
        });

        // CUARTO: Agregar el resto de los campos necesarios de la antigua tabla de pilotos
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
        // Eliminar foreign key de web_user_id
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->dropForeign(['web_user_id']);
        });

        // Eliminar unique constraint de user_telegram_id
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->dropUnique(['user_telegram_id']);
        });

        // Eliminar la columna id y las demás columnas agregadas
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->dropColumn(['id', 'dni', 'full_name', 'status', 'profile_photo_path', 'web_user_id']);
        });

        // Restaurar user_telegram_id como clave primaria
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->primary('user_telegram_id');
        });
    }
};
