<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Contact Information
            $table->string('name');
            $table->string('company');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->unsignedInteger('country_id');

            // Shipment Details
            $table->unsignedInteger('origin_country_id');
            $table->unsignedInteger('origin_city_id')->nullable();
            $table->string('origin_postal_code')->nullable();
            $table->unsignedInteger('destination_country_id');
            $table->unsignedInteger('destination_city_id')->nullable();
            $table->string('destination_postal_code')->nullable();

            // Cargo Information
            $table->text('description');
            $table->enum('cargo_type', [
                'general',
                'hazardous',
                'perishable',
                'fragile',
                'valuable'
            ])->default('general');
            $table->decimal('estimated_weight', 10, 2)->nullable();
            $table->enum('weight_unit', ['kg', 'lbs'])->default('kg');
            $table->json('dimensions')->nullable();
            $table->integer('pieces_count')->nullable();

            // Service Requirements
            $table->enum('service_type', [
                'air_freight',
                'sea_freight',
                'road_freight',
                'rail_freight',
                'multimodal',
                'roll_on_roll_off'
            ]);
            $table->string('container_size')->nullable();
            $table->enum('incoterm', [
                'EXW', 'FCA', 'CPT', 'CIP',
                'DAP', 'DPU', 'DDP', 'FAS',
                'FOB', 'CFR', 'CIF'
            ])->nullable();
            $table->date('expected_ship_date')->nullable();
            $table->boolean('insurance_required')->default(false);
            $table->boolean('customs_clearance_required')->default(false);
            $table->boolean('pickup_required')->default(false);
            $table->boolean('packing_required')->default(false);
            $table->text('special_requirements')->nullable();

            // Quote Status and Administrative
            $table->enum('status', [
                'pending',
                'processing',
                'quoted',
                'rejected',
            ])->default('pending');
            $table->foreignId('assigned_to')
                ->nullable()
                ->references('id')
                ->on('users')
                ->nullOnDelete();
            $table->decimal('quoted_price', 12, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->text('admin_notes')->nullable();
            $table->json('pricing_details')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('valid_until')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('service_type');
            $table->index('expected_ship_date');
            $table->index(['origin_country', 'destination_country']);
            $table->index('assigned_to');
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotes');
    }
};
