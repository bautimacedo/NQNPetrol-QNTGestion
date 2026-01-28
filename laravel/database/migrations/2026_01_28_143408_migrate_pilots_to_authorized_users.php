<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Migra datos de pilots a authorized_users y actualiza las relaciones en license
     */
    public function up(): void
    {
        // Mapear datos de pilots a authorized_users basándose en user_telegram_id
        $pilots = DB::table('pilots')->get();
        
        foreach ($pilots as $pilot) {
            // Buscar el authorized_user correspondiente por user_telegram_id
            $authorizedUser = DB::table('authorized_users')
                ->where('user_telegram_id', $pilot->user_telegram_id)
                ->first();
            
            if ($authorizedUser) {
                // Actualizar el authorized_user existente con datos del piloto
                DB::table('authorized_users')
                    ->where('id', $authorizedUser->id)
                    ->update([
                        'dni' => $pilot->dni,
                        'full_name' => $pilot->full_name,
                        'status' => $pilot->status,
                        'profile_photo_path' => $pilot->profile_photo ?? null,
                    ]);
                
                // Actualizar las licencias: cambiar pilot_id por authorized_user_id
                DB::table('license')
                    ->where('pilot_id', $pilot->id)
                    ->update(['pilot_id' => $authorizedUser->id]);
            } else {
                // Si no existe authorized_user, crear uno nuevo con los datos del piloto
                $newAuthorizedUserId = DB::table('authorized_users')->insertGetId([
                    'user_telegram_id' => $pilot->user_telegram_id,
                    'username' => null,
                    'mission_password' => '', // Se debe establecer después
                    'role' => 'operator',
                    'created_at' => $pilot->timestamp ?? now(),
                    'dni' => $pilot->dni,
                    'full_name' => $pilot->full_name,
                    'status' => $pilot->status,
                    'profile_photo_path' => $pilot->profile_photo ?? null,
                ]);
                
                // Actualizar las licencias
                DB::table('license')
                    ->where('pilot_id', $pilot->id)
                    ->update(['pilot_id' => $newAuthorizedUserId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Esta migración no se puede revertir fácilmente sin perder datos
        // Se recomienda hacer backup antes de ejecutar
    }
};
