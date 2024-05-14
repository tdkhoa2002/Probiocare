<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledAmountPairTrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trade__trades', function (Blueprint $table) {
            $table->double('amount_pair')->default(0)->nullable()->after('amount');
        });
        Schema::table('trade__tradehistories', function (Blueprint $table) {
            $table->double('amount_pair')->default(0)->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trade__trades', function (Blueprint $table) {
            $table->dropColumn('amount_pair');
        });
        Schema::table('trade__tradehistories', function (Blueprint $table) {
            $table->dropColumn('amount_pair');
        });
    }
}
