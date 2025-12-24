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
        // Esta migración actualiza la tabla si ya existe con la estructura antigua
        if (Schema::hasColumn('batteries', 'cycle_count')) {
            Schema::table('batteries', function (Blueprint $table) {
                $table->dropColumn(['cycle_count', 'health_percentage', 'drone_id']);
            });
        }
        
        if (!Schema::hasColumn('batteries', 'flight_count')) {
            Schema::table('batteries', function (Blueprint $table) {
                $table->integer('flight_count')->default(0)->after('serial');
                $table->timestamp('last_used')->nullable()->after('flight_count');
                $table->string('drone_name')->nullable()->after('last_used');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batteries', function (Blueprint $table) {
            if (Schema::hasColumn('batteries', 'flight_count')) {
                $table->dropColumn(['flight_count', 'last_used', 'drone_name']);
            }
            if (!Schema::hasColumn('batteries', 'cycle_count')) {
                $table->integer('cycle_count')->default(0);
                $table->decimal('health_percentage', 5, 2)->default(100.00);
                $table->foreignId('drone_id')->nullable();
            }
        });
    }
};
