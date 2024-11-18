<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentRoutesTable extends Migration
{
    public function up()
    {
        Schema::create('shipment_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained()->cascadeOnDelete();
            $table->string('location');
            $table->string('location_type')->nullable(); // airport, seaport, warehouse, etc.
            $table->dateTime('arrival_date');
            $table->dateTime('departure_date')->nullable();
            $table->dateTime('actual_arrival_date')->nullable();
            $table->dateTime('actual_departure_date')->nullable();
            $table->enum('status', ['pending', 'arrived', 'departed', 'skipped']);
            $table->integer('order');
            $table->string('carrier')->nullable();
            $table->string('vessel_number')->nullable();
            $table->string('container_number')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['shipment_id', 'order']);
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipment_routes');
    }
}
