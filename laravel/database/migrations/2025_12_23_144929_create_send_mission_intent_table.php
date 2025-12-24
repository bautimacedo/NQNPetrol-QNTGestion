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
        Schema::create('send_mission_intent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('mision_name')->nullable();
            $table->smallInteger('stage')->nullable();
            $table->unsignedBigInteger('sender')->nullable();

            $table->foreign('sender')->references('user_telegram_id')->on('authorized_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_mission_intent');
    }
};
