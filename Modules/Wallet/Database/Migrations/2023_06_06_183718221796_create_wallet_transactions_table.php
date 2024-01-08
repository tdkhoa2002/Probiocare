<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet__transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customer__customers')->onDelete('cascade');
            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->integer('blockchain_id')->unsigned()->nullable();
            $table->string('action');
            $table->double('amount');
            $table->double('amount_usd');
            $table->double('fee');
            $table->double('balance');
            $table->double('balanceBefore');
            $table->string('payment_method');
            $table->string('txhash');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('tag')->nullable();
            $table->integer('order')->nullable();
            $table->text('note')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('wallet__transactions');
    }
}
