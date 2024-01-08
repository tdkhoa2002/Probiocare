<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeertopeerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peertopeer__orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('ads_id')->unsigned();
            $table->foreign('ads_id')->references('id')->on('peertopeer__ads')->onDelete('cascade');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customer__customers')->onDelete('cascade');
            $table->integer('paymentmethod_id')->unsigned();
            $table->foreign('paymentmethod_id')->references('id')->on('paymentmethod_customers')->onDelete('cascade');
            $table->double('total_fiat_amount');
            $table->double('total_asset_amount');
            $table->string('type')->default('BUY'); // if ad type = BUY, order type = SELL
            // $table->double('total_receive_amount'); dư dùng
            $table->string('room_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peertopeer__orders');
    }
}
