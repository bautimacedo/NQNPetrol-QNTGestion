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
        Schema::create('purchase_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
            $table->enum('type', [
                'budget_request',
                'budget_pdf',
                'purchase_order',
                'invoice',
                'payment_order',
                'payment_proof',
                'tax_retention'
            ]);
            $table->string('file_path');
            $table->string('document_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_documents');
    }
};
