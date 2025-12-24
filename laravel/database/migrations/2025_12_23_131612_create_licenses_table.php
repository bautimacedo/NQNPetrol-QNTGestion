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
        Schema::create('license', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->unsignedBigInteger('pilot_id');
            $table->text('license_number');
            $table->text('category');
            $table->date('expiration_date');
            $table->timestamp('created_at');

            $table->foreign('pilot_id')->references('id')->on('pilots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license');
    }
};
