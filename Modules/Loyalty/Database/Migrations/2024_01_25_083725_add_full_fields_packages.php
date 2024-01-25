<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFullFieldsPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty__packages', function (Blueprint $table) {
            $table->integer('currency_stake_id')->unsigned();
            $table->foreign('currency_stake_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->integer('currency_reward_id')->unsigned();
            $table->foreign('currency_reward_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->double('min_stake');
            $table->double('max_stake');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('status')->default(true);
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
        Schema::table('loyalty__packages', function (Blueprint $table) {
            $table->dropForeign(['currency_stake_id']);
            $table->dropColumn('currency_stake_id');
            $table->dropForeign(['currency_reward_id']);
            $table->dropColumn('currency_reward_id');
            $table->dropColumn('min_stake');
            $table->dropColumn('max_stake');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('status');
        });
    }
}
