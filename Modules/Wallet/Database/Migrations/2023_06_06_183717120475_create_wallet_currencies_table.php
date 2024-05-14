<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet__currencies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code');
            $table->string('title');
            $table->string('type');
            $table->double('min_crawl')->nullable()->default(0);
            $table->double('transfer_fee')->nullable()->default(0);
            $table->integer('transfer_fee_type')->nullable()->default(0);
            $table->string('swap_enable')->nullable()->default(0);
            $table->double('swap_fee')->nullable()->default(0);
            $table->double('swap_fee_type')->nullable()->default(0);
            $table->double('min_swap')->nullable()->default(0);
            $table->double('max_swap')->nullable()->default(0);
            $table->double('usd_rate')->nullable()->default(0);
            $table->string('link_rate')->nullable();
            $table->double('total_supply')->nullable()->default(0);
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
        Schema::dropIfExists('wallet__currencies');
    }
}
