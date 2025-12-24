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
        Schema::create('Status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('drone')->unique();
            $table->text('event')->unique();

            $table->foreign('drone')->references('name')->on('Drone');
            $table->foreign('event')->references('event_id')->on('Logs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Status');
    }
};
