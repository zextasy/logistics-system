<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [
                'airway_bill',
                'bill_of_lading',
                'commercial_invoice',
                'packing_list',
                'certificate_of_origin',
                'customs_declaration',
                'insurance_certificate',
                'delivery_order'
            ]);
            $table->string('reference_number')->unique();
            $table->string('file_path');
            $table->enum('status', ['draft', 'active', 'revoked', 'expired']);
            $table->timestamp('generated_at');
            $table->timestamp('expires_at')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('reference_number');
            $table->index('status');
            $table->index(['shipment_id', 'type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
