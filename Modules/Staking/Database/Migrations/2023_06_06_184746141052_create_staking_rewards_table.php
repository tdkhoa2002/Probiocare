<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakingRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('staking__rewards', function (Blueprint $table) {
        //     $table->engine = 'InnoDB';
        //     $table->increments('id');
        //     // Your fields
        //     $table->integer('packageterm_id')->unsigned();
        //     $table->foreign('packageterm_id')->references('id')->on('staking__packageterms')->onDelete('cascade');
        //     //$table->integer('currency_reward_id')->unsigned();
        //     //$table->foreign('currency_reward_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
        //     $table->integer('apr_reward')->default(0);
        //     $table->boolean('status')->default(true);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('staking__rewards');
    }
}
