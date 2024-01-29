<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty__packages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('currency_stake_id')->unsigned();
            $table->foreign('currency_stake_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->integer('currency_reward_id')->unsigned();
            $table->foreign('currency_reward_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->integer('currency_cashback_id')->unsigned();
            $table->foreign('currency_cashback_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->double('min_stake');
            $table->double('max_stake');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('hour_reward')->default(1)->nullable();
            $table->boolean('principal_is_stake_currency')->nullable()->default(true);
            $table->boolean('require_entry')->default(false)->nullable();
            $table->integer('term_matching')->default(0)->nullable();
            $table->integer('principal_convert_rate')->default(0);
            $table->boolean('status')->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('loyalty__packages');
    }
}