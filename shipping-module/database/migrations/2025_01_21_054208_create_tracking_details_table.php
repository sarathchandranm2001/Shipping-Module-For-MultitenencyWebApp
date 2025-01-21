<?php
// database/migrations/xxxx_xx_xx_create_tracking_details_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('tracking_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('status');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracking_details');
    }
}
