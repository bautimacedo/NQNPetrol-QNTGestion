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
        Schema::create('weather_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestampTz('recorded_at')->nullable()->useCurrent();
            $table->text('city_name')->nullable();
            $table->decimal('temp_celsius', 10, 2)->nullable();
            $table->decimal('wind_speed_ms', 10, 2)->nullable();
            $table->decimal('wind_gust_ms', 10, 2)->nullable();
            $table->integer('visibility_meters')->nullable();
            $table->text('condition_main')->nullable();
            $table->text('condition_desc')->nullable();
            $table->boolean('is_flyable')->nullable();

            $table->unique('city_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_logs');
    }
};
