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
        Schema::create('Drone', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->unique();
            $table->text('dock')->nullable();
            $table->text('site')->nullable();
            $table->text('organization')->nullable();
            $table->double('Latitud')->nullable();
            $table->double('Longitud')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Drone');
    }
};
