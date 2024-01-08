<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketMakerTargetPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketmaker__targetprices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('market_id');
            $table->integer('customer_id');
            $table->double('amount')->default(0);
            $table->double('price')->default(0);
            $table->boolean('status')->default(1);
            $table->dateTime('schedule')->format('dd:MM:YYYY - HH:mm:ss');
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
        Schema::dropIfExists('marketmaker__targetprices');
    }
}
