<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCurrencyCommissionIdCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty__commissions', function (Blueprint $table) {
            $table->dropForeign(['currency_commission_id']);
            $table->dropColumn('currency_commission_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty__commissions', function (Blueprint $table) {
            $table->dropForeign(['currency_commission_id']);
            $table->dropColumn('currency_commission_id');
        });
    }
}
