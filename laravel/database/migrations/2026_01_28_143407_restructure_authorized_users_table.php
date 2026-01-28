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
        // 1. Forzamos la caída de la PK de Telegram y sus dependencias (Logs, send_mission_intent)
        DB::statement('ALTER TABLE authorized_users DROP CONSTRAINT authorized_users_pkey CASCADE');
    
        // 2. Agregamos el nuevo ID y lo hacemos PK
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
        });
    
        // 3. Devolvemos el user_telegram_id a su estado normal (único pero no PK)
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_telegram_id')->unique()->change();
        });
    
        // 4. Agregamos los campos de pilots
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->string('dni')->nullable()->after('user_telegram_id');
            $table->string('full_name')->nullable()->after('dni');
            $table->integer('status')->nullable()->default(0)->after('full_name');
            $table->string('profile_photo_path')->nullable()->after('status');
            $table->foreignId('web_user_id')->nullable()->after('profile_photo_path')->constrained('users')->onDelete('set null');
        });
    
        // 5. IMPORTANTE: Recreamos las Foreign Keys que el CASCADE borró
        DB::statement('ALTER TABLE "Logs" ADD CONSTRAINT logs_telegram_sender_fkey FOREIGN KEY (telegram_sender) REFERENCES authorized_users(user_telegram_id)');
        DB::statement('ALTER TABLE send_mission_intent ADD CONSTRAINT send_mission_intent_sender_fkey FOREIGN KEY (sender) REFERENCES authorized_users(user_telegram_id)');
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
