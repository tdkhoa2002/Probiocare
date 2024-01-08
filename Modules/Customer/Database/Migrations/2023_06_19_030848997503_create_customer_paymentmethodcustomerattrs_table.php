<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPaymentMethodCustomerAttrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentmethod_customerattrs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('payment_attr_id')->unsigned();
            $table->foreign('payment_attr_id')->references('id')->on('paymentmethod_attrs')->onDelete('cascade');
            $table->integer('payment_customer_id')->unsigned();
            $table->foreign('payment_customer_id')->references('id')->on('paymentmethod_customers')->onDelete('cascade');
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
        Schema::dropIfExists('paymentmethod_customerattrs');
    }
}
