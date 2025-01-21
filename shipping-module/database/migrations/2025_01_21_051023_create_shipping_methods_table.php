<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Self-Shipped, DHL
            $table->string('type'); // self-shipped, auto-shipped
            $table->decimal('flat_rate', 10, 2)->nullable(); // For self-shipped
            $table->time('service_start')->nullable(); // Service timings for auto-shipped
            $table->time('service_end')->nullable();
            $table->boolean('is_hyper_local')->default(false); // Flag for hyper-local
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_methods');
    }


};
