<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPaymentMethodAttrTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentmethod_attr_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->integer('payment_attr_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['payment_attr_id', 'locale']);
            $table->foreign('payment_attr_id')->references('id')->on('paymentmethod_attrs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymentmethod_attr_translations', function (Blueprint $table) {
            $table->dropForeign(['payment_attr_id']);
        });
        Schema::dropIfExists('paymentmethod_attr_translations');
    }
}
