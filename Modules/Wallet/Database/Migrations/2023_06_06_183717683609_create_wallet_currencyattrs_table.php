<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletCurrencyAttrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet__currencyattrs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('blockchain_id')->unsigned();
            $table->foreign('blockchain_id')->references('id')->on('wallet__blockchains')->onDelete('cascade');
            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->string('token_address');
            $table->longText('abi')->nullable();
            $table->integer('native_token')->nullable();
            $table->integer('decimal');
            $table->double('withdraw_fee_token')->nullable()->default(0);
            $table->tinyInteger('withdraw_fee_token_type')->nullable()->default(0);
            $table->double('withdraw_fee_chain')->nullable()->default(0);
            $table->double('value_need_approve')->nullable()->default(0);
            $table->integer('value_need_approve_currency')->nullable()->default(0);
            $table->double('max_amount_withdraw_daily')->nullable()->default(0);
            $table->integer('max_amount_withdraw_daily_currency')->nullable()->default(0);
            $table->integer('max_times_withdraw')->nullable()->default(0);
            $table->double('min_withdraw')->nullable()->default(0);
            $table->double('max_withdraw')->nullable()->default(0);
            $table->string('type_withdraw')->default('ONCHAIN');
            $table->string('type_deposit')->default('ONCHAIN');
            $table->string('type_transfer')->default('ONCHAIN');
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
        Schema::dropIfExists('wallet__currencyattrs');
    }
}
