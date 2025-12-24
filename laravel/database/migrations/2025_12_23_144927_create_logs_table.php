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
        Schema::create('Logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('event_id')->unique();
            $table->text('event_type')->nullable();
            $table->text('message')->nullable();
            $table->text('severity')->nullable();
            $table->text('dock')->nullable();
            $table->text('drone')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('altitude')->nullable();
            $table->text('site')->nullable();
            $table->text('organization')->nullable();
            $table->text('drone_battery')->nullable();
            $table->text('timestamp')->nullable();
            $table->text('flight_type')->nullable();
            $table->text('flight_name');
            $table->text('flight_responsable')->nullable();
            $table->unsignedBigInteger('telegram_sender')->nullable();
            $table->boolean('telegram')->nullable();

            $table->foreign('drone')->references('name')->on('Drone');
            $table->foreign('flight_name')->references('name')->on('mission');
            $table->foreign('telegram_sender')->references('user_telegram_id')->on('authorized_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Logs');
    }
};
