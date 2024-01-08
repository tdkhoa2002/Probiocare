<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryperrswapOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryperrswap__orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('order_code')->unique();
            $table->unsignedInteger('from_currency_id');
            $table->double('token_send');
            $table->string('address_order')->nullable();
            $table->unsignedInteger('to_currency_id');
            $table->string('receive_order');
            $table->double('token_receive')->nullable();
            $table->double('fee')->nullable();
            $table->string('email')->nullable();
            $table->string('type')->default('float');
            $table->string('order_service_id')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cryperrswap__orders');
    }
}
