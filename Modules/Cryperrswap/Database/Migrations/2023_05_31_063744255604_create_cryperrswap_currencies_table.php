<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryperrswapCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryperrswap__currencies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->unsignedInteger('service_id');
            $table->string('code')->nullable();
            $table->string('coin')->nullable();
            $table->string('name')->nullable();
            $table->string('network')->nullable();
            $table->integer('priority')->nullable();
            $table->integer('recv')->nullable();
            $table->integer('send')->nullable();
            $table->string('tag')->nullable();
            $table->string('logo')->nullable();
            $table->string('color')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('cryperrswap__currencies');
    }
}
