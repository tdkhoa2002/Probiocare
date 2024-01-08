<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staking__orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('code')->index();
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customer__customers')->onDelete('cascade');
            $table->integer('packageterm_id')->unsigned();
            $table->foreign('packageterm_id')->references('id')->on('staking__packageterms')->onDelete('cascade');
            $table->double('amount_stake')->default(0);
            $table->double('amount_usd_stake')->default(0);
            $table->dateTime('subscription_date');
            $table->dateTime('redemption_date')->nullable();
            $table->dateTime('last_time_reward')->nullable();
            $table->double('total_amount_reward')->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('staking__orders');
    }
}
