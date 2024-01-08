<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeTradeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade__tradehistories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->unsignedInteger('trade_id');
            $table->foreign('trade_id')->references('id')->on('trade__trades')->onDelete('cascade');
            $table->double('amount');
            $table->double('price');
            $table->double('fee');
            $table->double('fill');
            $table->string('trade_type');
            $table->boolean('is_maker')->default(false);
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
        Schema::dropIfExists('trade__tradehistories');
    }
}
