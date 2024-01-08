<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPaymentMethodTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentmethod_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->integer('paymentmethod_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['paymentmethod_id', 'locale']);
            $table->foreign('paymentmethod_id')->references('id')->on('paymentmethods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymentmethod_translations', function (Blueprint $table) {
            $table->dropForeign(['paymentmethod_id']);
        });
        Schema::dropIfExists('paymentmethod_translations');
    }
}
