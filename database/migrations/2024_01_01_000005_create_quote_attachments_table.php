<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2024_01_01_000001_create_shipments_table.php

// database/migrations/2024_01_01_000002_create_shipment_routes_table.php


// database/migrations/2024_01_01_000003_create_quotes_table.php


// database/migrations/2024_01_01_000004_create_documents_table.php


// database/migrations/2024_01_01_000005_create_quote_attachments_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('quote_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->integer('file_size');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('quote_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('quote_attachments');
    }
};
