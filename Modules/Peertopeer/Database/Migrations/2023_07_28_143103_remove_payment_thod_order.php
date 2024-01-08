<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePaymentThodOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peertopeer__orders', function (Blueprint $table) {
            $table->integer('paymentmethod_id')->unsigned()->nullable()->change();
            $table->string('code')->after('id');
            $table->integer('seller_id')->unsigned()->after('customer_id');
            $table->integer('buyer_id')->unsigned()->after('seller_id');
            $table->integer('fiat_currency_id')->unsigned()->after('buyer_id');
            $table->integer('asset_currency_id')->unsigned()->after('fiat_currency_id');
            $table->double('fixed_price')->nullable()->default(0)->after('asset_currency_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peertopeer__orders', function (Blueprint $table) {
            $table->dropColumn(['code', 'seller_id', 'buyer_id', 'fiat_currency_id', 'asset_currency_id','fixed_price']);
        });
    }
}
