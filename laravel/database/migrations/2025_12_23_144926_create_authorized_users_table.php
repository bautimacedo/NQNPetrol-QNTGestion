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
        Schema::create('authorized_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_telegram_id')->primary();
            $table->text('username')->nullable();
            $table->text('mission_password');
            $table->text('role')->nullable()->default('operator');
            $table->timestampTz('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authorized_users');
    }
};
