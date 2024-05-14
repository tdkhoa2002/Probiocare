<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakingCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staking__commissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('staking__packages')->onDelete('cascade');
            $table->integer('currency_commission_id')->unsigned();
            $table->foreign('currency_commission_id')->references('id')->on('wallet__currencies')->onDelete('cascade');
            $table->integer('level')->default(0);
            $table->double('commission')->default(0);
            $table->tinyInteger('type')->default(0);
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
        Schema::dropIfExists('staking__commissions');
    }
}
