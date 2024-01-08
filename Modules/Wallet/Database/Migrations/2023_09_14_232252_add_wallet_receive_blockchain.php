<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWalletReceiveBlockchain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallet__blockchains', function (Blueprint $table) {
            $table->string('wallet_receive')->nullable()->after('chainid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet__blockchains', function (Blueprint $table) {
            $table->dropColumn('wallet_receive');
        });
    }
}
