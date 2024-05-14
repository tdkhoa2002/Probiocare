<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade__markets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('symbol');
            $table->unsignedInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->unsignedInteger('currency_pair_id');
            $table->foreign('currency_pair_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->string('type')->nullable()->default('spot');
            $table->double('taker')->nullable()->default(0);
            $table->double('maker')->nullable()->default(0);
            $table->double('min_amount')->nullable()->default(0);
            $table->double('max_amount')->nullable()->default(0);
            $table->double('price')->nullable()->default(0);
            $table->double('price_usd')->nullable()->default(0);
            $table->double('price_change_24h')->nullable()->default(0);
            $table->double('hight_24h')->nullable()->default(0);
            $table->double('low_24h')->nullable()->default(0);
            $table->double('volume_24h')->nullable()->default(0);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('trade__markets');
    }
}
