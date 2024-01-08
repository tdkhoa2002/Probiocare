<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketMakerVolumnizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketmaker__volumnizers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('market_id');
            $table->integer('customer_id');
            $table->double('amount');
            $table->integer('interval');
            $table->dateTime('checkpoint');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->boolean('status');
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
        Schema::dropIfExists('marketmaker__volumnizers');
    }
}
