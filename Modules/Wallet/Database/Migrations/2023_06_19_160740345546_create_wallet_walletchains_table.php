<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletWalletChainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet__walletchains', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('wallet_id')->unsigned()->nullable();
            $table->foreign('wallet_id')->references('id')->on('wallet__wallets')->onDelete('cascade');
            $table->integer('blockchain_id')->unsigned()->nullable();
            $table->foreign('blockchain_id')->references('id')->on('wallet__blockchains')->onDelete('cascade');
            $table->string('address');
            $table->string('addressTag')->nullable();
            $table->text('private_key');
            $table->double('onhold')->nullable()->default(0);
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
        Schema::dropIfExists('wallet__walletchains');
    }
}
