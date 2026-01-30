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
        Schema::create('software_licenses', function (Blueprint $table) {
            $table->id();
            $table->string('software_name');
            $table->foreignId('provider_id')->nullable()->constrained('providers')->onDelete('set null');
            $table->string('license_key')->nullable();
            $table->string('license_number')->nullable();
            $table->date('expiration_date')->nullable();
            $table->integer('seats')->nullable()->comment('Número de licencias/dispositivos permitidos');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software_licenses');
    }
};
