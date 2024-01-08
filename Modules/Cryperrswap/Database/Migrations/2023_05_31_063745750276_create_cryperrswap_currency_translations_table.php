<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryperrswapCurrencyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryperrswap__currency_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('currency_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['currency_id', 'locale']);
            $table->foreign('currency_id')->references('id')->on('cryperrswap__currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cryperrswap__currency_translations', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
        });
        Schema::dropIfExists('cryperrswap__currency_translations');
    }
}
