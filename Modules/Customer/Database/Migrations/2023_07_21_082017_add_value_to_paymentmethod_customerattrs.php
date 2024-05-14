<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValueToPaymentmethodCustomerattrs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paymentmethod_customerattrs', function (Blueprint $table) {
            $table->string('value')->after('payment_customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymentmethod_customerattrs', function (Blueprint $table) {
            $table->dropColumn('value');
        });
    }
}
