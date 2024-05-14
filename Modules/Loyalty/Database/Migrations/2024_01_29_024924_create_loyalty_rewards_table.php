<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty__rewards', function (Blueprint $table) {
            $table->integer('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('loyalty__packages')->onDelete('cascade');
            $table->integer('currency_reward_id')->unsigned();
            $table->foreign('currency_reward_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->integer('apr_reward')->default(0);
           
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
        Schema::dropIfExists('loyalty__rewards');
    }
}
