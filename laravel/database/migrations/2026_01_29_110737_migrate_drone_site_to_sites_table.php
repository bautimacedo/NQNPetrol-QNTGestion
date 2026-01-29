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
        // 1. Extraer valores únicos de Drone.site y crear registros en sites
        $uniqueSites = DB::table('Drone')
            ->whereNotNull('site')
            ->where('site', '!=', '')
            ->distinct()
            ->pluck('site')
            ->filter()
            ->unique();

        foreach ($uniqueSites as $siteName) {
            DB::table('sites')->insertOrIgnore([
                'name' => $siteName,
                'location_details' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Agregar columna site_id a Drone
        Schema::table('Drone', function (Blueprint $table) {
            $table->foreignId('site_id')->nullable()->after('site')->constrained('sites')->onDelete('set null');
        });

        // 3. Migrar datos: relacionar Drone.site con sites.name
        $sites = DB::table('sites')->pluck('id', 'name');
        
        foreach ($sites as $siteName => $siteId) {
            DB::table('Drone')
                ->where('site', $siteName)
                ->update(['site_id' => $siteId]);
        }

        // 4. Eliminar la columna site de Drone
        Schema::table('Drone', function (Blueprint $table) {
            $table->dropColumn('site');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Agregar columna site de vuelta
        Schema::table('Drone', function (Blueprint $table) {
            $table->text('site')->nullable()->after('dock');
        });

        // 2. Migrar datos de vuelta: relacionar site_id con sites.name
        $sites = DB::table('sites')->pluck('name', 'id');
        
        foreach ($sites as $siteId => $siteName) {
            DB::table('Drone')
                ->where('site_id', $siteId)
                ->update(['site' => $siteName]);
        }

        // 3. Eliminar foreign key y columna site_id
        Schema::table('Drone', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
            $table->dropColumn('site_id');
        });
    }
};
