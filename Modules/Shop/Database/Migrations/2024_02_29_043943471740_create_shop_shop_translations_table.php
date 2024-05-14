<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopShopTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop__shop_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('shop_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['shop_id', 'locale']);
            $table->foreign('shop_id')->references('id')->on('shop__shops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop__shop_translations', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
        });
        Schema::dropIfExists('shop__shop_translations');
    }
}
