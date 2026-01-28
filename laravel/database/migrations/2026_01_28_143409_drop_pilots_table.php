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
        // Eliminar la tabla pilots ya que los datos fueron migrados a authorized_users
        Schema::dropIfExists('pilots');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recrear la tabla pilots (estructura básica)
        Schema::create('pilots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('dni');
            $table->integer('status');
            $table->timestamp('timestamp');
            $table->unsignedBigInteger('user_telegram_id');
            $table->string('profile_photo')->nullable();
        });
    }
};
