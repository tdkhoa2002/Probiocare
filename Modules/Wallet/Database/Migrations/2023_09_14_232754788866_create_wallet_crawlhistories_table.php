<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletCrawlHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet__crawlhistories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('walletchain_id')->unsigned();
            $table->foreign('walletchain_id')->references('id')->on('wallet__walletchains')->onDelete('cascade');
            $table->integer('crawldeposit_id')->unsigned();
            $table->foreign('crawldeposit_id')->references('id')->on('wallet__crawldeposits')->onDelete('cascade');
            $table->double('amount');
            $table->string('txhash');
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
        Schema::dropIfExists('wallet__crawlhistories');
    }
}
