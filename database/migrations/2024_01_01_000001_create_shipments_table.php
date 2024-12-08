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
            $table->unsignedInteger('origin_country_id');
            $table->unsignedInteger('origin_city_id');
            $table->string('loading_port')->nullable();
            $table->string('origin_address')->nullable();
            $table->string('origin_postal_code')->nullable();
            $table->unsignedInteger('destination_country_id');
            $table->unsignedInteger('destination_city_id');
            $table->string('discharge_port')->nullable();
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
            $table->string('shipper_address',1000)->nullable();
            $table->string('receiver_name');
            $table->string('receiver_phone')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('receiver_address',1000)->nullable();
            $table->string('consignee_name');
            $table->string('consignee_phone')->nullable();
            $table->string('consignee_email')->nullable();
            $table->string('consignee_address',1000)->nullable();

            // Tracking Information
            $table->string('vessel')->nullable();
            $table->string('current_location')->nullable();
            $table->dateTime('estimated_delivery');
            $table->dateTime('actual_delivery')->nullable();
            $table->dateTime('date_of_shipment')->nullable();
            $table->text('special_instructions')->nullable();

            // Customs Information
            $table->string('customs_status')->nullable();
            $table->json('customs_documents')->nullable();
            $table->boolean('customs_cleared')->default(false);

            // Commercial Information
            $table->decimal('declared_value', 12, 2)->nullable();
            $table->string('currency', 3)->nullable();
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
