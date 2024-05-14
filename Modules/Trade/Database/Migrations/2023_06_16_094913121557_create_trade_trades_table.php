<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade__trades', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customer__customers')->onDelete('cascade');
            // Your fields
            $table->unsignedInteger('market_id');
            $table->foreign('market_id')->references('id')->on('trade__markets')->onDelete('cascade');
            $table->double('amount');
            $table->double('price_was');
            $table->double('total_fee')->default(0)->nullable();
            $table->double('fee')->default(0)->nullable();
            $table->double('fill')->default(0)->nullable();
            $table->string('trade_type');
            $table->string('order_id')->nullable();
            $table->tinyInteger('status')->comment('0:open, 1:close/cancel,2:success');
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
        Schema::dropIfExists('trade__trades');
    }
}
