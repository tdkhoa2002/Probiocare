<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldIsSyncToWalletchain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallet__walletchains', function (Blueprint $table) {
            $table->boolean('is_sync')->after('onhold')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet__walletchains', function (Blueprint $table) {
            $table->dropColumn('is_sync');
        });
    }
}
