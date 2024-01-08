<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeertopeerAdsPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peertopeer__adspaymentmethods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('ads_id')->unsigned();
            $table->foreign('ads_id')->references('id')->on('peertopeer__ads')->onDelete('cascade');
            $table->integer('paymentmethod_id')->unsigned();
            $table->foreign('paymentmethod_id')->references('id')->on('paymentmethods')->onDelete('cascade');
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
        Schema::dropIfExists('peertopeer__adspaymentmethods');
    }
}
