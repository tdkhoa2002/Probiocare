<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyCashbackPackage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty__package', function (Blueprint $table) {
            $table->integer('currency_cashback_id')->unsigned();
            $table->foreign('currency_cashback_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty__package', function (Blueprint $table) {
            $table->dropForeign(['currency_cashback_id']);
            $table->dropColumn('currency_cashback_id');
        });
    }
}
