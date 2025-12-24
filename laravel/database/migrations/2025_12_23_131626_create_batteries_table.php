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
        Schema::create('batteries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('drone_name');
            $table->text('serial_number');
            $table->integer('flight_count');
            $table->text('status');
            $table->timestamp('last_used');

            $table->foreign('drone_name')->references('name')->on('Drone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batteries');
    }
};
