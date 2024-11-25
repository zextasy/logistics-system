<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tracking_number')->unique();
            $table->enum('type', ['air', 'sea', 'road', 'rail']);
            $table->enum('status', [
                'pending',
                'picked_up',
                'in_transit',
                'customs',
                'out_for_delivery',
                'delivered',
                'cancelled',
                'on_hold'
            ]);

            // Origin and Destination
            $table->string('origin_country');
            $table->string('origin_city');
            $table->string('origin_address')->nullable();
            $table->string('origin_postal_code')->nullable();
            $table->string('destination_country');
            $table->string('destination_city');
            $table->string('destination_address')->nullable();
            $table->string('destination_postal_code')->nullable();

            // Shipment Details
            $table->decimal('weight', 10, 2);
            $table->string('weight_unit')->default('kg');
            $table->json('dimensions')->nullable();
            $table->text('description');
            $table->string('container_size')->nullable();
            $table->string('service_type');

            // Contact Information
            $table->string('shipper_name');
            $table->string('shipper_phone')->nullable();
            $table->string('shipper_email')->nullable();
            $table->string('receiver_name');
            $table->string('receiver_phone')->nullable();
            $table->string('receiver_email')->nullable();

            // Tracking Information
            $table->string('current_location')->nullable();
            $table->dateTime('estimated_delivery');
            $table->dateTime('actual_delivery')->nullable();
            $table->text('special_instructions')->nullable();

            // Customs Information
            $table->string('customs_status')->nullable();
            $table->json('customs_documents')->nullable();
            $table->boolean('customs_cleared')->default(false);

            // Commercial Information
            $table->decimal('declared_value', 12, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->json('charges')->nullable();
            $table->boolean('insurance_required')->default(false);
            $table->decimal('insurance_amount', 12, 2)->nullable();

            // System Fields
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('tracking_number');
            $table->index('status');
            $table->index('current_location');
            $table->index('estimated_delivery');
            $table->index(['origin_country', 'destination_country']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};
