<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakingPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staking__packages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('currency_stake_id')->unsigned();
            $table->foreign('currency_stake_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->integer('currency_reward_id')->unsigned();
            $table->foreign('currency_reward_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->double('min_stake');
            $table->double('max_stake');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
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
        Schema::dropIfExists('staking__packages');
    }
}
