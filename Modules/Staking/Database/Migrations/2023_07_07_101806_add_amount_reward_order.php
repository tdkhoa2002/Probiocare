<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAmountRewardOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staking__orders', function (Blueprint $table) {
            $table->double('amount_reward')->default(0)->after('amount_usd_stake');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staking__orders', function (Blueprint $table) {
            $table->dropColumn('amount_reward');
        });
    }
}
