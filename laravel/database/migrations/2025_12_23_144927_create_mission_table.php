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
        Schema::create('mission', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->unique();
            $table->bigInteger('duration')->nullable();
            $table->text('link_rtcp')->nullable();
            $table->text('url')->nullable();
            $table->text('descrpition')->nullable();
            $table->text('drone')->nullable();
            $table->text('Authentication')->nullable();
            $table->json('payload')->nullable();
            $table->text('send_passwd')->nullable()->default('admin');

            $table->foreign('drone')->references('name')->on('Drone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission');
    }
};
