<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeertopeerAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peertopeer__ads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customer__customers')->onDelete('cascade');
            $table->unsignedInteger('fiat_currency_id');
            $table->foreign('fiat_currency_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->unsignedInteger('asset_currency_id');
            $table->foreign('asset_currency_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->double('fixed_amount')->nullable()->default(0);
            $table->double('total_filled')->nullable()->default(0);
            $table->double('total_trade_amount')->nullable()->default(0);
            $table->double('order_limit_min')->nullable()->default(0);
            $table->double('order_limit_max')->nullable()->default(0);
            $table->integer('payment_time_limit')->nullable()->default(0);
            $table->enum('type', ['SELL', 'BUY'])->default('SELL');
            $table->text('term')->nullable();
            $table->text('auto_reply')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('peertopeer__ads');
    }
}
