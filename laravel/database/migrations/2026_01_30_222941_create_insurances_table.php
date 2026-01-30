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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->string('insurer_name')->comment('Nombre de la aseguradora');
            $table->string('policy_number');
            $table->date('validity_date')->comment('Fecha de vigencia');
            $table->foreignId('provider_id')->nullable()->constrained('providers')->onDelete('set null');
            $table->text('coverage_details')->nullable();
            $table->decimal('premium_amount', 15, 2)->nullable();
            $table->string('currency', 3)->default('ARS');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
