<?php

// database/migrations/xxxx_xx_xx_create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->unsignedBigInteger('shipping_method_id');
            $table->string('tracking_id')->nullable();
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

